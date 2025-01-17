<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaffInformation;
use App\Models\StaffOther;
use App\Models\StaffRepresent;
use App\Models\Nationality;
use App\Models\Gender;
use App\Models\Age;
use App\Models\Region;
use App\Models\Contract;
use App\Models\Degree;
use App\Models\StaffDegree;
use App\Models\Operation;
use App\Models\According;
use App\Models\Opportunity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StaffController extends Controller
{

    // ------------- StaffRepresent Data -------------

    public function OrganizationStaffRepresentCEO()
    {
        $user_id = Auth::user()->id;
        $staffRepresent = StaffRepresent::where('user_id', $user_id)->first();
        $data = [
            'name_ceo' => $staffRepresent->name_ceo,
            'family_ceo' => $staffRepresent->family_ceo,
            'position_ceo' => $staffRepresent->position_ceo,
            'year_ceo' => $staffRepresent->year_ceo,
            'mobile_ceo' => $staffRepresent->mobile_ceo,
            'email_ceo' => $staffRepresent->email_ceo,
            'link_ceo' => $staffRepresent->link_ceo,
            'age_ceo' => $staffRepresent->age_ceo,
            'education_ceo' => $staffRepresent->education_ceo,
        ];
         return response()->json([
            'succeed' => true,
            'message' => 'Staff Represent fetched successfully',
            'data' => $data
        ]);
    }

    public function OrganizationStaffRepresentNotCEO()
    {
        $user_id = Auth::user()->id;
        $staffRepresent = StaffRepresent::where('user_id', $user_id)->first();
        $data = [
            'name_notCeo' => $staffRepresent->name_notCeo,
            'family_notCeo' => $staffRepresent->family_notCeo,
            'position_notCeo' => $staffRepresent->position_notCeo,
            'year_notCeo' => $staffRepresent->year_notCeo,
            'mobile_notCeo' => $staffRepresent->mobile_notCeo,
            'email_notCeo' => $staffRepresent->email_notCeo,
            'link_notCeo' => $staffRepresent->link_notCeo,
            'age_notCeo' => $staffRepresent->age_notCeo,
            'education_notCeo' => $staffRepresent->education_notCeo,
        ];
         return response()->json([
            'succeed' => true,
            'message' => 'Staff Represent fetched successfully',
            'data' => $data
        ]);
    }

    public function StaffRepresentStore(Request $request)
    {
        $user_id = Auth::user()->id;
        
        StaffRepresent::updateOrCreate(
            ['user_id' => $user_id],
            [
                'name_notCeo' => $request->name_notCeo,
                'name_ceo' => $request->name_ceo,
                'family_notCeo' => $request->family_notCeo,
                'family_ceo' => $request->family_ceo,
                'position_notCeo' => $request->position_notCeo,
                'position_ceo' => $request->position_ceo,
                'year_notCeo' => $request->year_notCeo,
                'year_ceo' => $request->year_ceo,
                'mobile_notCeo' => $request->mobile_notCeo,
                'mobile_ceo' => $request->mobile_ceo,
                'email_notCeo' => $request->email_notCeo,
                'email_ceo' => $request->email_ceo,
                'link_notCeo' => $request->link_notCeo,
                'link_ceo' => $request->link_ceo,
                'age_notCeo' => $request->age_notCeo,
                'age_ceo' => $request->age_ceo,
                'education_notCeo' => $request->education_notCeo,
                'education_ceo' => $request->education_ceo,
            ]
        );
        $staffRepresent = StaffRepresent::where('user_id', $user_id)->first();  
        return response()->json([
            'succeed' => true,
            'message' => 'StaffRepresent Data stored successfully',
            'data' => $staffRepresent,
        ]);
    }

    // ------------- Staff Saudi Data -------------
    public function OrganizationStaffConsulting($id)
    {
        $user_id = Auth::user()->id;
        $nationalities = Nationality::all();
        $saudiData = StaffInformation::where('user_id', $user_id)
                    ->where('nationality_id', $id) 
                    ->where('contract_id', 3)
                    ->get();

        if ($saudiData->isEmpty()) {
            return response()->json([
                'message' => 'No data found for the given nationality',
                'status' => 404
            ]);
        }

        return response()->json([
            'succeed' => true,
            'message' => 'Data fetched successfully',
            'data' => $saudiData,
        ]);
    }

    public function OrganizationStaffFulltime($id)
    {
        $user_id = Auth::user()->id;
        $nationalities = Nationality::all();
        $saudiData = StaffInformation::where('user_id', $user_id)
                    ->where('nationality_id', $id) 
                    ->where('contract_id', 1) 
                    ->get();

        if ($saudiData->isEmpty()) {
            return response()->json([
                'message' => 'No data found for the given nationality',
                'status' => 404
            ]);
        }

        return response()->json([
            'succeed' => true,
            'message' => 'Data fetched successfully',
            'data' => $saudiData,
        ]);
    }

    public function OrganizationStaffpartTime($id)
    {
        $user_id = Auth::user()->id;
        $nationalities = Nationality::all();
        $saudiData = StaffInformation::where('user_id', $user_id)
                    ->where('nationality_id', $id) 
                    ->where('contract_id', 2) 
                    ->get();

        if ($saudiData->isEmpty()) {
            return response()->json([
                'message' => 'No data found for the given nationality',
                'status' => 404
            ]);
        }

        return response()->json([
            'succeed' => true,
            'message' => 'Data fetched successfully',
            'data' => $saudiData,
        ]);
    }

    public function StaffSaudiStore(Request $request)
    {
        $user_id = Auth::user()->id;

        $data = $request->all();
        // Loop through the provided data and insert/update in the database
        foreach ($data['number'] as $nationalityId => $genders) {
            if (!is_array($genders)) {
                continue; // Skip if not an array
            }
            foreach ($genders as $genderId => $ages) {
                if (!is_array($ages)) {
                    continue;
                }
                foreach ($ages as $ageId => $contracts) {
                    if (!is_array($contracts)) {
                        continue;
                    }
                    foreach ($contracts as $contractId => $regions) {
                        if (!is_array($regions)) {
                            continue;
                        }
                        foreach ($regions as $regionId => $number) {
                            // Process only if $number is not null or empty
                            if (!is_null($number) && $number !== '') {
                                \Log::info("Processing: Nationality: $nationalityId, Gender: $genderId, Age: $ageId, Contract: $contractId, Region: $regionId, Number: $number");
        
                                StaffInformation::updateOrCreate(
                                    [
                                        'user_id' => $user_id,
                                        'nationality_id' => $nationalityId,
                                        'gender_id' => $genderId,
                                        'age_id' => $ageId,
                                        'contract_id' => $contractId,
                                        'region_id' => $regionId
                                    ],
                                    ['number' => $number]
                                );
                            }
                        }
                    }
                }
            }
        }
        $staffInformation = StaffInformation::where('user_id', $user_id)->get();

        return response()->json([
            'succeed' => true,
            'message' => 'Data Information stored successfully',
            'data' => $staffInformation,
        ]);
    }

    // ------------- Staff Qualifications Data -------------

    public function OrganizationStaffOpportunities()
    {
        $user_id = Auth::user()->id;
        $degrees = Degree::all();
        $operations = Operation::all();
        
        $staffDegreeData = [];

        foreach ($degrees as $degree) {
            $degreeData = [
                'operations' => []
            ];

            foreach ($operations as $operation) {
                // Get the existing data for the current degree and operation
                $staffDegree = StaffDegree::where('user_id', $user_id)
                    ->where('degree_id', $degree->id)
                    ->where('operation_id', $operation->id)
                    ->first();

                $operationData = [
                    'engaged' => $staffDegree->engaged ?? null,
                    'not_engaged' => $staffDegree->not_engaged ?? null,
                ];

                $degreeData['operations'][] = $operationData;
            }

            $staffDegreeData[] = $degreeData;
        }

        return response()->json([
            'succeed' => true,
            'message' => 'Qualifications Opportunities Data fetched successfully',
            'data' => $staffDegreeData,
        ]);
    }

    public function OrganizationStaffCertificates()
    {
        $user_id = Auth::user()->id;
        $degrees = Degree::all();
        $operations = Operation::all();
        
        $staffDegreeData = [];

        foreach ($degrees as $degree) {
            $degreeData = [
                'operations' => []
            ];

            foreach ($operations as $operation) {
                // Get the existing data for the current degree and operation
                $staffDegree = StaffDegree::where('user_id', $user_id)
                    ->where('degree_id', $degree->id)
                    ->where('operation_id', $operation->id)
                    ->first();

                $operationData = [
                    'certified' => $staffDegree->certified ?? null,
                    'not_certified' => $staffDegree->not_certified ?? null,
                ];

                $degreeData['operations'][] = $operationData;
            }

            $staffDegreeData[] = $degreeData;
        }

        return response()->json([
            'succeed' => true,
            'message' => 'Qualifications Certificates Data fetched successfully',
            'data' => $staffDegreeData,
        ]);
    }

    public function OrganizationStaffWork()
    {
        $user_id = Auth::user()->id;
        $degrees = Degree::all();
        $operations = Operation::all();
        
        $staffDegreeData = [];

        foreach ($degrees as $degree) {
            $degreeData = [
                'operations' => []
            ];

            foreach ($operations as $operation) {
                // Get the existing data for the current degree and operation
                $staffDegree = StaffDegree::where('user_id', $user_id)
                    ->where('degree_id', $degree->id)
                    ->where('operation_id', $operation->id)
                    ->first();

                $operationData = [
                    'office_work' => $staffDegree->office_work ?? null,
                    'field_work' => $staffDegree->field_work ?? null,
                    'mixed_work' => $staffDegree->mixed_work ?? null,
                ];

                $degreeData['operations'][] = $operationData;
            }

            $staffDegreeData[] = $degreeData;
        }

        return response()->json([
            'succeed' => true,
            'message' => 'Qualifications Work Data fetched successfully',
            'data' => $staffDegreeData,
        ]);
    }

    public function StaffQualificationsStore(Request $request)
    {
        $user_id = Auth::user()->id;

        // ------------- StaffDegree Data -------------
        foreach ($request->staffDegree as $degreeId => $operations) {
            foreach ($operations as $operationId => $data) {
                StaffDegree::updateOrCreate(
                    [
                        'user_id' => auth()->id(),
                        'degree_id' => $degreeId,
                        'operation_id' => $operationId,
                    ],
                    [
                        'engaged' => $data['engaged'],
                        'not_engaged' => $data['not_engaged'],
                        'certified' => $data['certified'],
                        'not_certified' => $data['not_certified'],
                        'office_work' => $data['office_work'],
                        'field_work' => $data['field_work'],
                        'mixed_work' => $data['mixed_work'],
                        'total' => $data['total'],
                        'is_volunteer' => 0,
                    ]
                );
            }
        }
        $staffDegree = StaffDegree::where('user_id', $user_id)->get();

        return response()->json([
            'data' => $staffDegree,
            'message' => 'Data stored successfully',
            'status' => 200
        ]);
    }

    // ------------- Staff Others Data -------------
    public function OrganizationStaffOther()
    {
        $user_id = Auth::user()->id;
        $staffOthers = StaffOther::where('user_id', $user_id)->first();
        return response()->json([
            'succeed' => true,
            'message' => 'Data fetched successfully',
            'data' => $staffOthers,
        ]);
    }

    public function StaffOtherStore(Request $request)
    {
        $user_id = Auth::user()->id;

        StaffOther::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'benefit_male' => $request->benefit_male,
                'benefit_female' => $request->benefit_female,
                'benefit_total' => $request->benefit_total,
                'fees_male' => $request->fees_male,
                'fees_female' => $request->fees_female,
                'fees_total' => $request->fees_total,
                'free_male' => $request->free_male,
                'free_female' => $request->free_female,
                'free_total' => $request->free_total,
                'expenses_male' => $request->expenses_male,
                'expenses_female' => $request->expenses_female,
                'expenses_total' => $request->expenses_total,
                'value_male' => $request->value_male,
                'value_female' => $request->value_female,
                'value_total' => $request->value_total,
                'graduates_male' => $request->graduates_male,
                'graduates_female' => $request->graduates_female,
                'graduates_total' => $request->graduates_total,
                'fullTime_male' => $request->fullTime_male,
                'fullTime_female' => $request->fullTime_female,
                'fullTime_total' => $request->fullTime_total,
                'partTime_male' => $request->partTime_male,
                'partTime_female' => $request->partTime_female,
                'partTime_total' => $request->partTime_total,
                'consulting_male' => $request->consulting_male,
                'consulting_female' => $request->consulting_female,
                'consulting_total' => $request->consulting_total,
                'management_male' => $request->management_male,
                'management_female' => $request->management_female,
                'management_total' => $request->management_total,
                'workers_male' => $request->workers_male,
                'workers_female' => $request->workers_female,
                'workers_total' => $request->workers_total,
                'trainees_male' => $request->trainees_male,
                'trainees_female' => $request->trainees_female,
                'trainees_total' => $request->trainees_total,
            ]
        );
        $staffOther = StaffOther::where('user_id', $user_id)->first();

        return response()->json([
            'succeed' => true,
            'message' => 'Data stored successfully',
            'data' => $staffOther,
        ]);
    }




}
