<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Services\BlockChainService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;

class CertificateController extends Controller
{
    protected $blockchainService;

    public function __construct(BlockChainService $blockchainService)
    {
        $this->blockchainService = $blockchainService;
    }

    public function addCertificate(Request $request)
    {
        try{

            $request->validate([
                'student_id' => 'required|exists:students,id',
                'certificate_type' => 'required|string',
                'issue_date' => 'required|date',
                'expiry_date' => 'nullable|date',
                'issued_by' => 'required|string',
                'result' => 'required|string',
                'academic_year_id' => 'required|exists:academic_years,id',
                'additional_details' => 'nullable|string',
            ]);

            $previousHash = $this->blockchainService->getPreviousHash(Certificate::class);
            $timestamp = now();
            $calculatedHash = $this->blockchainService->calculateHash(
                $previousHash,
                json_encode($request->all()),
                $timestamp->format('Y-m-d H:i:s')
            );

            $certificateData = $request->all();
            $certificateData['previous_hash'] = $previousHash;
            $certificateData['hash'] = $calculatedHash;

            $certificate = Certificate::create($certificateData);

            return response()->json($certificate,200);

        }catch (Exception $e) {
            return $this->handleException($e, 'Failed to create certificate');
        }
    }

    public function verifyCertificate(Request $request)
    {
        // Find the Certificate by its ID
        $certificate = Certificate::findOrFail($request->id);

        if (!$certificate) {
            return response()->json(['message' => 'Certificate not found'], 404);
        }

        // Convert timestamp to Carbon instance if it's stored as a string
        $timestamp = Carbon::parse($certificate->timestamp);

        // Recalculate hash based on Certificate data
        $calculatedHash = $this->blockchainService->calculateHash(
            $certificate->previous_hash,
            json_encode($certificate),
            $timestamp->format('Y-m-d H:i:s') // Ensure timestamp is formatted correctly
        );

        // Compare the calculated hash with the stored hash
        if ($calculatedHash !== $certificate->hash) {
            return response()->json(['message' => 'Certificate has been tampered with'], 400);
        }

        // Check if the previous hash matches the previous Certificate's hash (if it exists)
        if ($certificate->previous_hash === '0000000000000000000000000000000000000000000000000000000000000000') {
            return response()->json(['message' => 'Certificate is valid and verified'], 200);
        }

        $previousCertificate = Certificate::where('hash', $certificate->previous_hash)->first();

        if ($previousCertificate) {
            return response()->json(['message' => 'Certificate is valid and verified'], 200);
        }

        return response()->json(['message' => 'Invalid Certificate chain'], 400);
    }

}
