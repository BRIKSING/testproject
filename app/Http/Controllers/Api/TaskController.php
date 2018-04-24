<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\User;
use App\Doing;

class TaskController extends Controller
{
    public function TaskCreate(Request $request)
    {
      $userHeader = $request->header('Authorization');
      $taskOptions = $request->all();
      $user = User::where('token', $userHeader)->first();
      // return ['what' => $userHeader];
      if(!$user) {
        return ['error' => 'There is no that user!'];
      }

      $user_id = $user->id;
      $taskOptions['user_id'] = $user_id;

      $task = Doing::create($taskOptions);
      return $task;
    }

    public function TaskUpdate(Request $request)
    {
        $task = Doing::where('id', $request->id)->first();

        $task->name = $request->name;
        $task->description = $request->description;
        $task->date = $request->date;
        $task->period_id = $request->period_id;

        $task->save();

        return $task;
    }

    public function TaskDelete(Request $request)
    {
        $task = Doing::where('id', $request->id)->first();

        $task->delete();

        return [
          'message' => 'Doing was successfuly deleted!'
        ];
    }

    public function GetTasks(Request $request, $month, $year)
    {
        $token = $request->header('Authorization');
        $user = User::where('token', $token)->first();

        $userTasks = Doing::where('user_id', $user->id)
                          ->whereMonth('date', $month)
                          ->whereYear('date', '20'.$year)
                          ->get();
        $otherTasks = Doing::whereMonth('date', $month)
                            ->whereYear('date', '20'.$year)
                            ->get()
                            ->diff($userTasks);

        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        for ($i=1; $i <= $days; $i++) {
          $array_days[$i] = [];
        }

        foreach ($userTasks as $task) {
          preg_match("/\-(\d{1,2})$/", $task['date'], $match);
          $findMonth = $match[1];
          array_push($array_days[$findMonth], $task);
        }
        return $array_days;
    }

    public function NewGetTasks(Request $request, $month, $year)
    {
      $token = $request->header('Authorization');
      $user = User::where('token', $token)->first();

      $userTasks = $user->doings()->get();
      $otherTasks = Doing::get()->diff($userTasks);

      $resultTasks = [];
      $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
      for ($i=1; $i <= $days; $i++) {
        $resultTasks[$i] = [];
      }

      $resultTasks = $this->setDoingsOnCalendar($userTasks, $resultTasks, $days, $month, $year);

      $resultTasks = $this->setDoingsOnCalendar($otherTasks, $resultTasks, $days, $month, $year);

      // dd($resultTasks);

      return [
        'userTasks' => $resultTasks
      ];
    }

    public function setDoingsOnCalendar($Tasks, $resultTasks, $days, $month, $year)
    {
      foreach ($Tasks as $task) {
        switch($task->period_id) {
          case '1': //year
            $monthPattern = "/(\d{1,2})-(\d{1,2})$/";
            preg_match($monthPattern, $task['date'], $match);

            $taskDay = preg_replace("/^0/", "", $match[2]);
            $taskMonth = preg_replace("/^0/", "", $match[1]);

            if($month == $taskMonth) {
              $resultTasks[$taskDay][] = $task;
            }
            break;
          case '2': //month
            $dayPattern = "/(\d{1,2})$/";
            preg_match($dayPattern, $task['date'], $match);

            $taskDay = preg_replace("/^0/", "", $match[1]);
            $resultTasks[$taskDay][] = $task;
            break;
          case '3': //week
            // $dayPattern = "/(\d{1,2})$/";
            // preg_match($dayPattern, $task['date'], $match);
            // $taskDay = preg_replace("/^0/", "", $match[1]);

            $dayOfWeek = date("w", strtotime($task['date']));

            for ($i = 1; $i <= $days; $i++) {

              $curDay = mb_strlen($i) > 1 ? $i : "0".$i;
              $curMonth = mb_strlen($month) > 1 ? $month : "0".$month;
              $curDate = preg_replace("/(\d{1,2})-(\d{1,2})$/", $curMonth."-".$curDay, $task['date']);
              $curDayOfWeek = date("w", strtotime($curDate));
                // dump([
                //   'curDay' => $curDay,
                //   'curMonth' => $curMonth,
                //   'curDate' => $curDate,
                //   'curDayOfWeek' => $curDayOfWeek,
                //   'DayOfWeek'=> $dayOfWeek
                // ]);
              if($curDayOfWeek == $dayOfWeek) {
                $resultTasks[$i][] = $task;
              }
            }
            //$resultTasks[$taskDay][] = $task;
            break;
          case '4': //day
            for ($i = 1; $i <= $days; $i++) {
              $resultTasks[$i][] = $task;
            }
            break;
          default:
            $yearPattern = "/^\d{2}(\d{2})-(\d{1,2})-(\d{1,2})$/";
            preg_match($yearPattern, $task['date'], $match);

            $taskYear = preg_replace("/^0/", "", $match[1]);
            $taskMonth = preg_replace("/^0/", "", $match[2]);
            $taskDay = preg_replace("/^0/", "", $match[3]);

            if($taskYear == $year && $taskMonth == $month) {
              $resultTasks[$taskDay][] = $task;
            }
            break;
        }
      }

      return $resultTasks;
    }
}
