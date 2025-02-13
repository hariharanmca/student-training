<?php  
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrainingSchedule;
use Illuminate\Support\Facades\Validator;
use Exception;

class TrainingScheduleController extends Controller
{
    public function index()
    {
        try {
            $schedules = TrainingSchedule::with('course')->get();
            return response()->json($schedules, 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching the schedules.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'course_id' => 'required|exists:courses,id',
                'start_time' => 'required|date',
                'end_time' => 'required|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $schedule = TrainingSchedule::create($request->all());

            return response()->json(['message' => 'Training schedule created successfully', 'schedule' => $schedule], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating the schedule.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(TrainingSchedule $schedule)
    {
        try {
            return response()->json($schedule->load('course'), 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching the schedule.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, TrainingSchedule $schedule)
    {
        try {
            $validator = Validator::make($request->all(), [
                'course_id' => 'required|exists:courses,id',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $schedule->update($request->all());

            return response()->json(['message' => 'Training schedule updated successfully', 'schedule' => $schedule], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the schedule.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(TrainingSchedule $schedule)
    {
        try {
            $schedule->delete();

            return response()->json(['message' => 'Training schedule deleted successfully'], 204);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the schedule.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
