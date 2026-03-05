<?php

namespace App\Http\Controllers;

use App\Exports\ExportForm;
use App\Exports\ExportExcel;
use App\Models\ReceiptForm;
use App\Models\ReceiptDetail;
use App\Models\FileUpload;
use App\Http\Controllers\Controller;
//use App\Http\Controllers\ReceiptController;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
// use File;
use Illuminate\Support\Facades\File;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use App\Models\Receipt_RunningNumber;
use App\Models\Receipt_Customer_RunningNumber;
// use Mail;
use App\Mail\ContactMail;
use App\Models\FormGrades;
use App\Models\FormManage;
use App\Models\FormPakages;
use App\Models\OpeningClosingTime;
use App\Models\ReferentCode;
use App\Models\ReferentURL;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
// use App\Exports\ExportUser;

class ReceiptFormController extends Controller
{
  //
  const sfielda = [
    //sfild => route
    '0' => 'reward',
    // '1' => null, //* null */
    '2' => 'GMEC',
    '3' => null, //* null */
    '4' => 'IMOCSEA',
    '5' => 'INFINITE Spelling Bee',
    '6' => 'GELOSEA',
    '7' => 'LIMOC',
    '8' => 'STEM',
    '9' => 'OLPCS',
    '10' => 'ASIAROPE',
    '11' => 'Cambridge',
    '12' => null, //* null */
    '13' => 'ISOCSEA',
    '14' => 'IMOCSEA+ISOCSEA',
    '15' => 'Huaxiacup',
    '16' => 'Mathleague',
    '17' => 'test_field', //* test field */
    '18' => 'mathleague-II',
    '19' => 'Huaxiacup-II',
    '20' => 'neos',
    '21' => 'neos-2', //* sup form */
    '22' => 'huaxiacup-final-round',
    '23' => 'ihcmi',
    '24' => 'isc',
    '25' => 'seacso',
    '26' => 'copernicus',
    '27' => 'coding-olympics',
    '28' => 'imocsea_special',
    '29' => 'stemco_science',
    '30' => 'advance_english_grammar',
    '31' => 'isocsea_imocsea_national_round_2025',
    '32' => 'isocsea_imocsea_national_round',
  ];

  public function generateUrl()
  {
    $referent_code = ReferentCode::all();
    return view('receipt_form.generate_url')->with([
      'referent_code' => $referent_code,
    ]);
  }

  public function generateUrlSave(Request $request)
  {
    $request->validate([
      'route' => 'required',
      'referent_code' => 'required',
      'comments' => 'nullable',
    ]);

    $route = $request->input('route');
    $comments = $request->input('comments');

    $url = route($route, ['referent_code' => $request->input('referent_code')]);

    ReferentURL::create([
      'user_id' => Auth::user()->id,
      'comments' => $comments,
      'route' => $route,
      'referent_url' => $url,
      'referent_code' => $request->input('referent_code'),
    ]);

    return redirect(route('referent_url'));
  }

  public function referent_urlEdit(Request $request)
  {
    $request->validate([
      'id' => 'required',
    ]);
    $referent_code = ReferentCode::all();
    $referent_url = ReferentURL::find($request->id);
    return response()->json([
      'success' => true,
      'referent_code' => $referent_code,
      'referent_url' => $referent_url,
    ]);
  }

  public function referent_urlEditSave(Request $request)
  {
    $request->validate([
      'id' => 'required',
      'referent_code' => 'required',
      'route' => 'required',
      'comments' => 'nullable',
    ]);
    $url = route($request->route, ['referent_code' => $request->referent_code]);
    $referent_url = ReferentURL::find($request->id);
    $referent_url->referent_code = $request->referent_code;
    $referent_url->route = $request->route;
    $referent_url->comments = $request->comments;
    $referent_url->user_id = Auth::user()->id;
    $referent_url->referent_url = $url;
    $referent_url->save();

    return response()->json([
      'success' => true,
      'message' => 'Referent url updated successfully',
    ]);
  }

  public function referent_urlDelete(Request $request)
  {
    $referent_url = ReferentURL::find($request->id);
    $referent_url->delete();
    return response()->json([
      'success' => true,
      'message' => 'Referent url deleted successfully',
    ]);
  }

  public function referent_url()
  {
    $referent_code = ReferentCode::all();
    $referent_url = ReferentURL::all();
    return view('receipt_form.referent_url')->with([
      'referent_code' => $referent_code,
      'referent_url' => $referent_url,
    ]);
  }

  public function referent_code()
  {
    $referent_code = ReferentCode::all();
    return view('receipt_form.referent_code')->with([
      'referent_code' => $referent_code,
    ]);
  }
  public function generate_code()
  {
    return view('receipt_form.generate_code');
  }

  public function referent_codeSave(Request $request)
  {
    $request->validate([
      'referent_name' => 'required|string|max:255',
      'comments' => 'nullable|string|max:500',
    ]);

    $user_id = Auth::id();

    // สุ่มโค้ดที่ไม่ซ้ำ
    do {
      $referent_code = Str::random(10);
    } while (ReferentCode::where('referent_code', $referent_code)->exists());

    // บันทึกข้อมูล
    ReferentCode::create([
      'referent_code' => $referent_code,
      'user_id' => $user_id,
      'referent_name' => $request->referent_name,
      'comments' => $request->comments,
    ]);

    return response()->json([
      'success' => true,
      'message' => 'Referent code created successfully',
      'code' => $referent_code, // เผื่อส่งกลับไปใช้ต่อ
    ]);
  }

  public function referent_codeEdit(Request $request)
  {
    $referent_code = ReferentCode::find($request->id);
    return response()->json([
      'success' => true,
      'referent_code' => $referent_code,
    ]);
  }

  public function referent_codeEditSave(Request $request)
  {
    $request->validate([
      'referent_name' => 'required|string|max:255',
      'comments' => 'nullable|string|max:500',
    ]);

    $user_id = Auth::id();

    $referent_code = ReferentCode::find($request->id);
    $referent_code->referent_name = $request->referent_name;
    $referent_code->comments = $request->comments;
    $referent_code->user_id = $user_id;
    $referent_code->save();

    return response()->json([
      'success' => true,
      'message' => 'Referent code created successfully',
      'code' => $referent_code,
    ]);
  }

  public function referent_codeDelete(Request $request)
  {
    $referent_code = ReferentCode::find($request->id);
    $referent_url = ReferentURL::where(
      'referent_code',
      $referent_code->referent_code,
    )->delete();

    $receipt_form = ReceiptForm::where(
      'referent_code',
      $referent_code->referent_code,
    )->get();
    foreach ($receipt_form as $form) {
      $form->update([
        'referent_code' => null,
      ]);
    }

    $receipt = Receipt::where(
      'referent_code',
      $referent_code->referent_code,
    )->get();
    foreach ($receipt as $receipt) {
      $receipt->update([
        'referent_code' => null,
      ]);
    }

    $referent_code->delete();
    return response()->json([
      'success' => true,
      'message' => 'Referent code deleted successfully',
    ]);
  }

  public function getDatetime($route)
  {
    $set_time = OpeningClosingTime::where('route', $route)
      ->orderBy('id', 'desc')
      ->first();
    if ($set_time->status === 'Online') {
      $dt_start = new \DateTime($set_time->opening_time);
      $dt_closs = new \DateTime($set_time->closing_time);
      $start = $dt_start->format('d F Y');
      $closs = $dt_closs->format('d F Y');
      $date = $start . ' - ' . $closs;
    } else {
      $start = 'null date';
      $closs = 'null date';
      $date = $start . ' to ' . $closs;
    }
    return $date;
  }

  public function getForm()
  {
    $route = request()->route()->getName();
    $date = $this->getDatetime($route);
    $form = FormManage::where('form_route', $route)->first();
    return view('forms_manage.view', compact('form', 'date'));
  }

  public function asiarope()
  {
    return $this->getForm();
  }
  public function admin_test_field()
  {
    return $this->getForm();
  }

  public function isc()
  {
    return $this->getForm();
  }
  public function gmec()
  {
    return $this->getForm();
  }
  public function ihcmi()
  {
    return $this->getForm();
  }

  public function olpcs()
  {
    return $this->getForm();
  }

  public function test_field()
  {
    return $this->getForm();
  }
  public function mathleague()
  {
    return $this->getForm();
  }

  public function mathleague_II()
  {
    return $this->getForm();
  }

  public function huaxiacup()
  {
    return $this->getForm();
  }
  public function huaxiacupFinalRound()
  {
    return $this->getForm();
  }
  public function neos()
  {
    return $this->getForm();
  }

  public function neos2()
  {
    return $this->getForm();
  }

  public function huaxiacup_II()
  {
    return $this->getForm();
  }

  public function img_reward()
  {
    return $this->getForm();
  }

  public function imocsea()
  {
    return $this->getForm();
  }

  public function isocsea()
  {
    return $this->getForm();
  }

  public function imocsea_isocsea()
  {
    return $this->getForm();
  }

  public function award_ceremony_isocsea()
  {
    return $this->getForm();
    // $route = request()->route()->getName();
    // $date = $this->getDatetime($route);
    // return view("receipt_form.advance_english_grammar")->with(['date' => $date]);
  }
  public function imocsea_national_round()
  {
    return $this->getForm();
    // $route = request()->route()->getName();
    // $date = $this->getDatetime($route);
    // return view("receipt_form.advance_english_grammar")->with(['date' => $date]);
  }

  public function cambridge()
  {
    return $this->getForm();
  }
  public function seacso()
  {
    return $this->getForm();
  }
  public function copernicus()
  {
    return $this->getForm();
  }
  public function codingOlympics()
  {
    return $this->getForm();
  }
  public function imocsea_special()
  {
    return $this->getForm();
  }

  public function spelling_bee_islo()
  {
    return $this->getForm();
  }

  //แสดง form แบบใหม่
  public function showFormBySlug($slug)
  {
    // dd($slug);
    $form = FormManage::where('slug', $slug)->first();

    if (!$form) {
      abort(404, 'Form not found');
    }

    // Get datetime using slug as route
    $date = $this->getDatetime($slug);

    return view('forms_manage.view', compact('form', 'date'));
  }

  //สร้าง form แบบเดิม
  public function generalForm()
  {
    $route = request()->route()->getName();
    $date = $this->getDatetime($route);
    return view('receipt_form.generalForm')->with(['date' => $date]);
  }

  public function gelosea()
  {
    $route = request()->route()->getName();
    $date = $this->getDatetime($route);
    return view('receipt_form.gelosea')->with(['date' => $date]);
  }

  public function stemco_science()
  {
    $route = request()->route()->getName();
    $date = $this->getDatetime($route);
    return view('receipt_form.stemco_science')->with(['date' => $date]);
  }
  public function advance_english_grammar()
  {
    $route = request()->route()->getName();
    $date = $this->getDatetime($route);
    return view('receipt_form.advance_english_grammar')->with([
      'date' => $date,
    ]);
  }

  public function isocsea_imocsea_national_round()
  {
    $route = request()->route()->getName();
    $date = $this->getDatetime($route);
    return view('receipt_form.isocsea_imocsea_national_round')->with([
      'date' => $date,
    ]);
  }

  public function isocsea_imocsea_national_round_2025()
  {
    $route = request()->route()->getName();
    $date = $this->getDatetime($route);
    return view('receipt_form.isocsea_imocsea_national_round_2025')->with([
      'date' => $date,
    ]);
  }

  public function fileStore(Request $request)
  {
    // dd($request);

    $validator = Validator::make($request->all(), [
      'file.*' => 'required', // max:10240 is 10 MB
      // 'file.*' => 'required|mimes:jpeg,png,pdf,doc,docx|max:10240', // max:10240 is 10 MB
    ]);

    if ($validator->fails()) {
      return response()->json(['error' => $validator->errors()->first()], 400);
    }
    $filecount = count($request->file('file'));

    $newname = '';
    for ($i = 0; $i <= $filecount - 1; $i++) {
      $image = $request->file('file')[$i];
      $imageName = $image->getClientOriginalName();
      $oldfile = FileUpload::where('oldname', $imageName)->get();
      if (!is_array($oldfile)) {
        $newname = Str::random(40) . '_' . $imageName;
        $image->move(public_path('form_images'), $newname);

        $imageUpload = new FileUpload();
        $imageUpload->filename = $newname;
        $imageUpload->oldname = $imageName;
        $imageUpload->save();
      }
    }
    return response()->json(['success' => $newname]);
  }

  public function fileStoreAPI(Request $request)
  {
    //$image = $request->file('file');
    //$imageName = $image->getClientOriginalName();

    //$newname = Str::random(40) . "_" . $imageName;
    //$image->move(public_path('form_images'), $newname);

    //return response()->json(['success' => $newname]);
  }

  public function fileDestroy(Request $request)
  {
    $filename = $request->get('name');
    $oldfile = FileUpload::where('oldname', $filename)->get();

    if ($oldfile->isEmpty()) {
      return $filename;
    }

    $path = public_path() . '/form_images/' . $oldfile[0]->filename;
    if (file_exists($path)) {
      unlink($path);
      FileUpload::where('oldname', $filename)->delete();
    } else {
      FileUpload::where('oldname', $filename)->delete();
    }
    return $filename;
  }

  public function delete_all_between($beginning, $end, $string)
  {
    $beginningPos = strpos($string, $beginning);
    $endPos = strpos($string, $end);
    if ($beginningPos === false || $endPos === false) {
      return $string;
    }

    $textToDelete = substr(
      $string,
      $beginningPos,
      $endPos + strlen($end) - $beginningPos,
    );

    return $this->delete_all_between(
      $beginning,
      $end,
      str_replace($textToDelete, '', $string),
    );
  }

  public function textWatermark($image, $text)
  {
    $path = public_path('receipt_form_images/' . $image);

    if (file_exists($path)) {
      $img = Image::make(public_path('receipt_form_images/' . $image));

      $img->text($text, 610, 670, function ($font) {
        $font->file(public_path('font/amandasignature.ttf'));
        $font->size(60);
        $font->color('#ff0000');
        $font->align('center');
        $font->valign('bottom');
        $font->angle(80);
      });

      $img->save(public_path('receipt_form_watermark_images/' . $image));

      $img->encode('png');
      $type = 'png';
      $new_image = 'data:image/' . $type . ';base64,' . base64_encode($img);

      //return view('show_watermark', compact('new_image'));
      return $new_image;
    }
  }

  public function check_permission()
  {
    if (Auth::check()) {
      if (
        Auth::user()->level == 1 ||
        Auth::user()->level == 3 ||
        Auth::user()->level == 0
      ) {
        return true;
      } else {
        abort(403, 'Unauthorized action.');
      }
    } else {
      abort(403, 'Unauthorized action.');
      //return Redirect("login")->withSuccess('Please Login');
      //exit();
    }
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  // public function searchMonthYear($month, $year, $sfield)
  // {
  //     $receipt = ReceiptForm::select(
  //         "receipt_forms.id as receipt_id",
  //         "receipt_forms.sfield as receipt_sfield",
  //         "receipt_forms.submission_date as receipt_submission_date",
  //         "receipt_forms.first_name as receipt_firstname",
  //         "receipt_forms.last_name as receipt_lastname",
  //         "receipt_forms.name_parent as receipt_parent_name",
  //         "receipt_forms.mobile as receipt_mobile",
  //         "receipt_forms.generate as receipt_generate",
  //         "receipt_forms.photo_att as file",
  //     )
  //         ->where('receipt_forms.sfield', $sfield)
  //         ->orderBy("receipt_forms.id", "desc")
  //         ->whereMonth('receipt_forms.submission_date', $month)
  //         ->whereYear('receipt_forms.submission_date', $year)
  //         ->get();

  //     return $receipt;
  // }

  public function index(Request $request)
  {
    //
    $this->check_permission();
    if ($request->sfield == '') {
      abort(403, 'Please input Field');
    }

    if ($request->ajax()) {
      //sleep(2);
      $receipt = ReceiptForm::select(
        'receipt_forms.id as receipt_id',
        'receipt_forms.exam_mode as exam_mode',
        'receipt_forms.sfield as receipt_sfield',
        'receipt_forms.submission_date as receipt_submission_date',
        'receipt_forms.first_name as receipt_firstname',
        'receipt_forms.middle_name as receipt_middlename',
        'receipt_forms.last_name as receipt_lastname',
        'receipt_forms.name_parent as receipt_parent_name',
        'receipt_forms.mobile as receipt_mobile',
        'receipt_forms.generate as receipt_generate',
        'receipt_forms.photo_att as file',
        'receipt_forms.referent_code as referent_code',
        'receipt_forms.email as email',
      )
        ->where('receipt_forms.sfield', $request->sfield)
        ->orderBy('receipt_forms.id', 'desc');
      if ($request->start_date && $request->end_date) {
        # code...
        $receipt->whereBetween('receipt_forms.submission_date', [
          $request->start_date,
          $request->end_date,
        ]);
      }
      if ($request->referent_code) {
        $receipt->where('receipt_forms.referent_code', $request->referent_code);
      }
      //print_r($levels);
      //exit();
      $receipt = $receipt->get();

      return datatables()
        ->of($receipt)
        /* ->editColumn('student_name', function (Receipt $receipt) {
                    return $receipt->student_name . ' ' . $receipt->student_lastname;
                })*/
        ->editColumn('checkbox', function ($row) {
          return '<input type="checkbox" id="' .
            $row->receipt_id .
            '" class="flat" name="table_records[]" value="' .
            $row->receipt_id .
            '" >';
        })

        ->addColumn('receipt_status', function ($row) {
          if ($row->receipt_generate == 0) {
            $html =
              '<i class="text-danger fa fa-edit"></i> ยังไม่ได้ออกใบเสร็จ ';
          } else {
            $html = '<i class="text-success fa fa-edit"></i> ออกใบเสร็จแล้ว ';
          }
          return $html;
        })
        ->addColumn('referent_code', function ($row) {
          return $row->referent_code;
        })
        ->addColumn('exam_mode', function ($row) {
          return $row->exam_mode;
        })
        ->addColumn('referent_name', function ($row) {
          $name = '';
          $referent_code = $row->referent_code;
          $referent_code = ReferentCode::where(
            'referent_code',
            $referent_code,
          )->first();
          if ($referent_code) {
            $name = $referent_code->referent_name;
          }
          return $name;
        })
        ->addColumn('action', function ($row) {
          $html = '';

          if ($row->receipt_sfield == '23' && $row->file) {
            $files = explode('|', $row->file);

            foreach ($files as $file) {
              if (!empty($file)) {
                $filePath = public_path('receipt_form_images/' . $file);

                if (file_exists($filePath)) {
                  $html .=
                    '<a href="' .
                    asset('receipt_form_images/' . $file) .
                    '" class="btn btn-xs btn-info btn-edit"><i class="fa fa-download"></i> Download file</a> ';
                } else {
                  $html .=
                    '<p class="text-danger">File ' .
                    htmlspecialchars($file) .
                    ' does not exist.</p>';
                }
              }
            }
          }

          if ($row->receipt_generate == 0) {
            if ($row->receipt_sfield == '23') {
              # code...
            } else {
              # code...
              $html .=
                '<a href="#" class="btn btn-xs btn-warning btn-edit" id="getEditData" data-id="' .
                $row->receipt_id .
                '"><i class="fa fa-edit"></i> Generate Receipt</a> ';
            }

            $html .=
              '<a href="#" data-rowid="' .
              $row->receipt_id .
              '" class="btn btn-xs btn-danger btn-delete"><i class="fa fa-trash"></i> Delete</a>';
          } else {
            if ($row->receipt_sfield == '23') {
              # code...
            } else {
              # code...
              $html .=
                '<a href="#" class="btn btn-xs btn-warning btn-edit" id="getEditData" data-id="' .
                $row->receipt_id .
                '"><i class="fa fa-edit"></i> Edit</a> ';
            }
            $html .=
              '<a href="#" onclick="toastr.success(\'ออก Receive แล้วไม่สามารถลบได้\', {
                            timeOut: 5000
                        });" data-rowid="' .
              $row->receipt_id .
              '" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</a>';
          }

          // Add Resend Mail button
          if (!in_array($row->receipt_sfield, [0, 17], true) && $row->email) {
            $html .=
              ' <a href="#" class="btn btn-xs btn-info btn-resend-mail" data-id="' .
              $row->receipt_id .
              '"><i class="fa fa-envelope"></i> Resend Mail</a>';
          }

          return $html;
        })
        ->rawColumns(['checkbox', 'receipt_status', 'action'])
        ->toJson();
    }

    //get subject
    //$subject = Subject::orderBy("id", "asc")->get();

    //get student
    //$student = Student::orderBy("name", "asc")->get();
    $form = FormManage::where('sfield', $request->sfield)->first();
    $sfielda = self::sfielda;

    if ($form) {
      $sfielda = array_replace($sfielda, [
        (string) $form->sfield => $form->form_name,
      ]);
    }
    $referent_codes = ReferentCode::orderBy('id', 'asc')->get();

    return view('receipt_form.index')
      ->with(['sfielda' => $sfielda])
      ->with(['sfield' => $request->sfield])
      ->with(['form' => $form])
      ->with(['referent_codes' => $referent_codes]);
  }
  public function index_all(Request $request)
  {
    //
    $this->check_permission();

    if ($request->ajax()) {
      //sleep(2);
      $receipt = ReceiptForm::select(
        'receipt_forms.id as receipt_id',
        'receipt_forms.sfield as receipt_sfield',
        'receipt_forms.submission_date as receipt_submission_date',
        'receipt_forms.first_name as receipt_firstname',
        'receipt_forms.middle_name as receipt_middlename',
        'receipt_forms.last_name as receipt_lastname',
        'receipt_forms.name_parent as receipt_parent_name',
        'receipt_forms.mobile as receipt_mobile',
        'receipt_forms.generate as receipt_generate',
        'receipt_forms.photo_att as file',
        'receipt_forms.referent_code as referent_code',
        'receipt_forms.email as email',
      )
        ->where('receipt_forms.sfield', $request->sfield)
        ->orderBy('receipt_forms.id', 'desc');
      if ($request->start_date && $request->end_date) {
        # code...
        $receipt->whereBetween('receipt_forms.submission_date', [
          $request->start_date,
          $request->end_date,
        ]);
      }
      if ($request->referent_code) {
        $receipt->where('receipt_forms.referent_code', $request->referent_code);
      }
      //print_r($levels);
      //exit();
      $receipt = $receipt->get();

      return datatables()
        ->of($receipt)
        /* ->editColumn('student_name', function (Receipt $receipt) {
                    return $receipt->student_name . ' ' . $receipt->student_lastname;
                })*/
        ->editColumn('checkbox', function ($row) {
          return '<input type="checkbox" id="' .
            $row->receipt_id .
            '" class="flat" name="table_records[]" value="' .
            $row->receipt_id .
            '" >';
        })

        ->addColumn('receipt_status', function ($row) {
          if ($row->receipt_generate == 0) {
            $html =
              '<i class="text-danger fa fa-edit"></i> ยังไม่ได้ออกใบเสร็จ ';
          } else {
            $html = '<i class="text-success fa fa-edit"></i> ออกใบเสร็จแล้ว ';
          }
          return $html;
        })
        ->addColumn('referent_code', function ($row) {
          return $row->referent_code;
        })
        ->addColumn('referent_name', function ($row) {
          $name = '';
          $referent_code = $row->referent_code;
          $referent_code = ReferentCode::where(
            'referent_code',
            $referent_code,
          )->first();
          if ($referent_code) {
            $name = $referent_code->referent_name;
          }
          return $name;
        })
        ->addColumn('action', function ($row) {
          $html = '';

          if ($row->receipt_sfield == '23' && $row->file) {
            $files = explode('|', $row->file);

            foreach ($files as $file) {
              if (!empty($file)) {
                $filePath = public_path('receipt_form_images/' . $file);

                if (file_exists($filePath)) {
                  $html .=
                    '<a href="' .
                    asset('receipt_form_images/' . $file) .
                    '" class="btn btn-xs btn-info btn-edit"><i class="fa fa-download"></i> Download file</a> ';
                } else {
                  $html .=
                    '<p class="text-danger">File ' .
                    htmlspecialchars($file) .
                    ' does not exist.</p>';
                }
              }
            }
          }

          if ($row->receipt_generate == 0) {
            if ($row->receipt_sfield == '23') {
              # code...
            } else {
              # code...
              $html .=
                '<a href="#" class="btn btn-xs btn-warning btn-edit" id="getEditData" data-id="' .
                $row->receipt_id .
                '"><i class="fa fa-edit"></i> Generate Receipt</a> ';
            }

            $html .=
              '<a href="#" data-rowid="' .
              $row->receipt_id .
              '" class="btn btn-xs btn-danger btn-delete"><i class="fa fa-trash"></i> Delete</a>';
          } else {
            if ($row->receipt_sfield == '23') {
              # code...
            } else {
              # code...
              $html .=
                '<a href="#" class="btn btn-xs btn-warning btn-edit" id="getEditData" data-id="' .
                $row->receipt_id .
                '"><i class="fa fa-edit"></i> Edit</a> ';
            }
            $html .=
              '<a href="#" onclick="toastr.success(\'ออก Receive แล้วไม่สามารถลบได้\', {
                            timeOut: 5000
                        });" data-rowid="' .
              $row->receipt_id .
              '" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</a>';
          }

          // Add Resend Mail button
          if (!in_array($row->receipt_sfield, [0, 17], true) && $row->email) {
            $html .=
              ' <a href="#" class="btn btn-xs btn-info btn-resend-mail" data-id="' .
              $row->receipt_id .
              '"><i class="fa fa-envelope"></i> Resend Mail</a>';
          }

          return $html;
        })
        ->rawColumns(['checkbox', 'receipt_status', 'action'])
        ->toJson();
    }

    $referent_codes = ReferentCode::orderBy('id', 'asc')->get();
    $formManage = FormManage::orderBy('id', 'asc')->get();

    $mergeArray = self::sfielda;

    foreach ($formManage as $form) {
      if (!array_key_exists($form->sfield, $mergeArray)) {
        $mergeArray[$form->sfield] = $form->form_name;
      }
    }

    // dd($mergeArray);

    return view('receipt_form.index_all')
      ->with(['sfielda' => $mergeArray])
      ->with(['sfield' => $request->sfield])
      ->with(['formManage' => $mergeArray])
      ->with(['referent_codes' => $referent_codes]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */

  /**
   * Check if user is already registered with similar name (threshold) and extra factors
   *
   * @param string $route
   * @param string $sfield
   * @param string $firstname
   * @param string $lastname
   * @param string|null $birthdate  // raw input format as submitted
   * @param string|null $phone      // raw input phone
   * @param string|null $email      // raw input email
   * @return array
   */
  public function checkRegisted(
    $route,
    $sfield,
    $firstname,
    $lastname,
    $birthdate = null,
    $phone = null,
    $email = null,
  ) {
    $getTime = OpeningClosingTime::where('route', $route)
      ->orderBy('id', 'desc')
      ->first();
    $getTimeOpen_dt = new \DateTime($getTime->opening_time);
    $getTimeClose_dt = new \DateTime($getTime->closing_time);
    $getTimeOpen = $getTimeOpen_dt->format('Y-m-d');
    $getTimeClose = $getTimeClose_dt->format('Y-m-d');

    // First, check for exact match
    $exactMatch = ReceiptForm::where([
      ['first_name', '=', $firstname],
      ['last_name', '=', $lastname],
      ['sfield', '=', $sfield],
    ])
      ->whereBetween('submission_date', [$getTimeOpen, $getTimeClose])
      ->first();

    if ($exactMatch) {
      return [
        'receipt' => $exactMatch,
        'checkRegisted' => true,
        'matchType' => 'exact',
      ];
    }

    // If no exact match, check for similar names
    $similarRecords = ReceiptForm::where('sfield', $sfield)
      ->whereBetween('submission_date', [$getTimeOpen, $getTimeClose])
      ->get();

    $similarityThreshold = 80; // 98% similarity threshold per policy (Option B)
    $similarRecord = null;
    $sameBirthFlag = false;
    $contactMatchFlag = false; // สำหรับ Option B จะหมายถึง เบอร์ และ อีเมล ตรงกัน
    $isSamePersonFlag = false;

    // Normalize ชื่อก่อนคำนวณ similarity: ลบอักขระที่ไม่ใช่ตัวอักษร/ช่องว่าง, lowercase, บีบช่องว่างซ้ำ
    $normalize_name = function ($value) {
      $text = (string) ($value ?? '');
      $text = mb_strtolower(trim($text), 'UTF-8');
      // เก็บเฉพาะตัวอักษรทุกภาษาและช่องว่าง
      $text = preg_replace('/[^\p{L}\s]+/u', '', $text);
      // บีบช่องว่างหลายตัวให้เหลือ 1 ช่อง
      $text = preg_replace('/\s+/u', ' ', $text);
      return $text ?? '';
    };

    foreach ($similarRecords as $record) {
      $firstNameSimilarity = 0;
      $lastNameSimilarity = 0;

      $first_norm = $normalize_name($firstname);
      $record_first_norm = $normalize_name($record->first_name);
      $last_norm = $normalize_name($lastname);
      $record_last_norm = $normalize_name($record->last_name);

      similar_text($first_norm, $record_first_norm, $firstNameSimilarity);
      similar_text($last_norm, $record_last_norm, $lastNameSimilarity);

      // ตรวจสอบทั้งชื่อและนามสกุลต้องคล้ายกันทั้งคู่
      if (
        $firstNameSimilarity >= $similarityThreshold &&
        $lastNameSimilarity >= $similarityThreshold
      ) {
        $similarRecord = $record;
        // คำนวณค่าเฉลี่ยความคล้ายคลึง
        $avgSimilarity = ($firstNameSimilarity + $lastNameSimilarity) / 2;

        // ตรวจสอบปัจจัยระบุตัวตนเพิ่มเติม: วันเกิด + (มือถือ หรือ อีเมล)
        $input_birth = is_null($birthdate) ? '' : trim((string) $birthdate);
        $record_birth = is_null($record->birth_date)
          ? ''
          : trim((string) $record->birth_date);
        $sameBirthFlag =
          $input_birth !== '' &&
          $record_birth !== '' &&
          $input_birth === $record_birth;

        $input_mobile_norm = preg_replace('/\D+/', '', (string) ($phone ?? ''));
        $record_mobile_norm = preg_replace(
          '/\D+/',
          '',
          (string) ($record->mobile ?? ''),
        );
        $phoneMatch =
          $input_mobile_norm !== '' &&
          $record_mobile_norm !== '' &&
          $input_mobile_norm === $record_mobile_norm;

        $input_email_norm = strtolower(trim((string) ($email ?? '')));
        $record_email_norm = strtolower(trim((string) ($record->email ?? '')));
        $emailMatch =
          $input_email_norm !== '' &&
          $record_email_norm !== '' &&
          $input_email_norm === $record_email_norm;

        // Option B: ต้องตรงทั้งเบอร์ และ อีเมล
        $contactMatchFlag = $phoneMatch && $emailMatch;
        $isSamePersonFlag = $sameBirthFlag && $contactMatchFlag;

        break;
      }
    }

    if ($similarRecord) {
      return [
        'receipt' => $similarRecord,
        'checkRegisted' => true,
        'matchType' => 'similar',
        'similarity' => $avgSimilarity,
        'same_birth' => $sameBirthFlag,
        'contact_match' => $contactMatchFlag,
        'is_same_person' => $isSamePersonFlag,
      ];
    }

    return [
      'receipt' => null,
      'checkRegisted' => false,
      'matchType' => 'none',
    ];
  }

  public function create(Request $request)
  {
    //
    // if ($request->get('sfield') === "18" || $request->get('sfield') === "19") {
    // if ($request->get('sfield') === "19") {
    //     dd('error');
    // }

    // $test = Receipt::find(1893);
    // dd($test->recform->id);
    $this->check_permission();
    // dd($request->all());
    if ($request->get('sfield') === '17') {
      $validator = Validator::make($request->all(), [
        'submission_date' => 'required|string',
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        // 'street_address' => 'required|string',
        //'city' => 'required|string',
        //'province' => 'required|string',
        // 'postcode' => 'required|string',
        // 'name_parent' => 'required|string',
        'mobile' => 'required|string',
        'package' => 'required|string',
        //'file_att' => 'required|string',
        'description' => 'required|string',
        'grade' => 'required|string',
      ]);
    } else {
      # code...
      $validator = Validator::make($request->all(), [
        'submission_date' => 'required|string',
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'street_address' => 'required|string',
        //'city' => 'required|string',
        //'province' => 'required|string',
        'postcode' => 'required|string',
        'name_parent' => 'required|string',
        'mobile' => 'required|string',
        'package' => 'required|string',
        //'file_att' => 'required|string',
        'description' => 'required|string',
        'grade' => 'required|string',
      ]);
    }

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()->all()]);
    }

    $id = $request->get('fid');
    $form = ReceiptForm::find($id);

    if ($request->get('sfield') === '17') {
      $adminEmail = $request->get('email');
      Mail::to($adminEmail)->send(new ContactMail($form));
    }

    if ($form->generate == 1) {
      return response()->json(['error' => 'Receive is already generate']);
    }

    $rnumber = Receipt_RunningNumber::generate(
      $request->get('sfield'),
      $request->get('submission_date'),
    );

    $rcnumber = Receipt_Customer_RunningNumber::generate(
      $request->get('sfield'),
    );
    // dd($request);

    $request->request->add([
      'receipt_number' => $rnumber,
      'receipt_customer_number' => $rcnumber,
    ]);

    $receipt = new Receipt($request->all());
    $receipt->recform_id = $form->id;
    $receipt->referent_code = $request->get('referent_code');
    $receipt->save();
    // dd(
    //     $request,
    //     $adminEmail
    // );

    //$form = ReceiptForm::find($id);

    //add more inages
    $img = $request->get('img');
    $stu = '';
    $urlbr = '';
    if ($img != null || $img != '') {
      foreach ($img as $fileb) {
        //echo $filea;
        // $stu .= $sss . "|";
        $oldfile = FileUpload::where('oldname', $fileb)->get();
        $stu .= $oldfile[0]->filename . '|';
        File::move(
          public_path() . '/form_images/' . $oldfile[0]->filename,
          public_path() . '/receipt_form_images/' . $oldfile[0]->filename,
        );

        //watermark
        $urlb = url('/') . '/receipt_form_images/' . $oldfile[0]->filename;

        //watermark
        $fileex = explode('/', $urlb);
        $this->textWatermark(
          end($fileex),
          'Date Register : ' . $request->get('submission_date'),
        );
        $urlbr .=
          str_replace(
            'receipt_form_images',
            'receipt_form_watermark_images',
            $urlb,
          ) . '|';
        //watermark

        FileUpload::where('filename', $oldfile[0]->filename)->delete();
      }
    }

    $dataimg = ReceiptForm::find($request->get('fid'));
    if ($dataimg->file_att != null && $dataimg->file_att != '') {
      $stu = $dataimg->file_att . '|' . $stu;
    }

    $datare = Receipt::find($receipt->id);
    if ($datare->file_att != null && $datare->file_att != '') {
      $urlbr = $datare->file_att . '|' . $urlbr;
    }

    $stu = rtrim($stu, '|');
    $urlbr = rtrim($urlbr, '|');

    ReceiptForm::find($request->get('fid'))->update(['file_att' => $stu]);
    Receipt::find($receipt->id)->update(['file_att' => $urlbr]);
    //add more images
    $rid = $receipt->id;

    if (strtolower($request->get('dcode')) == 'meta200') {
      $discount = 200;
    } elseif (strtolower($request->get('dcode')) == 'cem100') {
      $discount = 100;
    } elseif (strtolower($request->get('dcode')) == 'cbp100') {
      $discount = 100;
    } elseif (strtolower($request->get('dcode')) == 'cbl150') {
      $discount = 150;
    } else {
      $discount = 0;
    }

    if ($request->get('sfield') === '17') {
      # code...
      $price = 500;
      $out_price = FormPakages::find($request->get('package_id'));
      if ($out_price) {
        $price = $out_price->price;
      } else {
        $out_price = $this->delete_all_between(
          '(',
          ')',
          $request->get('package'),
        );
        $price = preg_replace('/[^0-9.]/', '', $out_price);
      }
    } else {
      $package_ids = json_decode($form->package_id);

      if ($form->package_id && is_array($package_ids)) {
        # code...
        foreach ($package_ids as $key => $id) {
          $out_price = FormPakages::find($id);
          $price = $out_price->price;
          $desc = $out_price->package;
          $rdata = new ReceiptDetail([
            'receipt_id' => $rid,
            'description' => $desc,
            'quantity' => 1,
            //'unit' => '',
            'unitprice' => (int) $price,
            'discount' => $discount,
            //'amount' => $request->get('book_old_price'),
          ]);
          $rdata->save();
        }
      } else {
        # code...

        $out_price = FormPakages::find($request->get('package_id'));
        if ($out_price) {
          $price = $out_price->price;
        } else {
          $out_price = $this->delete_all_between(
            '(',
            ')',
            $request->get('package'),
          );
          $price = preg_replace('/[^0-9.]/', '', $out_price);
        }
        $rdata = new ReceiptDetail([
          'receipt_id' => $rid,
          'description' => $request->get('description'),
          'quantity' => 1,
          //'unit' => '',
          'unitprice' => (int) $price,
          'discount' => $discount,
          //'amount' => $request->get('book_old_price'),
        ]);
        $rdata->save();
      }

      # code...
    }

    if ($request->get('sfield') == 11) {
      if (str_contains($request->get('description'), 'Primary')) {
        $sdes = 'ค่าลงทะเบียนระดับประถม';
      } else {
        $sdes = 'ค่าลงทะเบียนระดับมัธยม';
      }
    } else {
      if (
        $request->get('sfield') == 16 ||
        $request->get('sfield') == 17 ||
        $request->get('sfield') == 24 ||
        $request->get('sfield') == 25
      ) {
        $sdes = '';
      } elseif (
        $request->get('sfield') == 18 ||
        $request->get('sfield') == 19
      ) {
        if (str_contains($request->get('description'), 'Private')) {
          $sdes = 'สมัครติวแบบส่วนตัว';
        } else {
          $sdes = 'สมัครติว';
        }
      } elseif (
        $request->get('sfield') == 20 ||
        $request->get('sfield') == 21
      ) {
        # code...
        $sdes = 'สมัครสอบปกติ';
      } else {
        if (str_contains($request->get('description'), 'tutoring')) {
          $sdes = 'สมัครสอบรวมติว';
        } elseif (
          $request->get('sfield') == 10 ||
          $request->get('sfield') == 27
        ) {
          # code...
          $sdes = '';
        } else {
          $sdes = 'สมัครสอบไม่รวมติว';
        }
      }
    }

    $formSfield = FormManage::where('sfield', $request->get('sfield'))->first();
    if ($formSfield) {
      $sdes = '';
    } else {
      $sdes = $sdes;
    }

    $rtdata = new ReceiptDetail([
      'receipt_id' => $rid,
      'description' => $sdes,
      //'quantity' => 1,
      //'unit' => '',
      //'unitprice' => (int)$price,
      //'discount' => '',
      //'amount' => $request->get('book_old_price'),
    ]);
    $rtdata->save();
    // dd($rdata);

    $form->generate = '1';
    $form->rec_id = $receipt->id;
    $form->save();
    return response()->json(['success' => 'Receive Add successfully']);
  }

  protected function buildDynamicValidationRules($route, $allowedTLDs)
  {
    $formManage = FormManage::where('form_route', $route)->first();

    if (!$formManage || !$formManage->field_settings) {
      return $this->getDefaultValidationRules($allowedTLDs);
    }

    $fieldSettings = $formManage->field_settings;
    $fieldConfig = config('form_fields', []);
    $rules = [];
    $messages = [];

    $fieldMapping = [
      'student_first_name' => 'firstname',
      'student_last_name' => 'lastname',
      'student_nick_name' => 'nickname',
      'date_of_birth' => 'birthdate',
      'student_school_name' => 'schoolname',
      'student_grade' => 'grade',
      'package' => 'package',
      'student_address' => 'address',
      'student_zip' => 'postcode',
      'parent_name' => 'parent',
      'parent_phone' => 'phone',
      'contact_email' => 'email',
      'news' => 'newsf',
    ];

    foreach ($fieldMapping as $configKey => $inputName) {
      $settings = $fieldSettings[$configKey] ?? null;

      if (!is_array($settings)) {
        continue;
      }

      $enabled =
        $settings['enabled'] ??
        ($fieldConfig[$configKey]['default_enabled'] ?? true);
      $required =
        $settings['required'] ??
        ($fieldConfig[$configKey]['default_required'] ?? false);

      if (!$enabled) {
        continue;
      }

      $ruleArray = [];

      if ($required) {
        $ruleArray[] = 'required';
      } else {
        $ruleArray[] = 'nullable';
      }

      // Special handling for package field (can be string or array)
      if ($inputName === 'package') {
        // Check if multi-select is enabled
        if ($formManage->package_multiselect) {
          // Multi-select: expect array
          $rules[$inputName] = $required
            ? ['required', 'array']
            : ['nullable', 'array'];
          $rules[$inputName . '.*'] = ['integer', 'exists:forms_pakages,id'];
          $messages["{$inputName}.required"] = 'กรุณาเลือกแพคเกจ';
          $messages["{$inputName}.array"] = 'แพคเกจต้องเป็นรายการ';
          $messages["{$inputName}.*.integer"] = 'แพคเกจไม่ถูกต้อง';
          $messages["{$inputName}.*.exists"] = 'แพคเกจที่เลือกไม่มีในระบบ';

          // Add max selection validation if set
          if ($formManage->package_max_selection) {
            $rules[$inputName][] = 'max:' . $formManage->package_max_selection;
            $messages["{$inputName}.max"] =
              'คุณสามารถเลือกได้สูงสุด ' .
              $formManage->package_max_selection .
              ' แพคเกจเท่านั้น';
          }
        } else {
          // Single select: expect string or integer
          $ruleArray[] = 'string';
          $rules[$inputName] = $ruleArray;
        }
      } elseif (in_array($inputName, ['firstname', 'lastname', 'nickname'])) {
        $ruleArray[] = 'string';
        $ruleArray[] = 'regex:/^[A-Za-z ]+$/';
        $messages["{$inputName}.regex"] =
          ucfirst($inputName) . ' ต้องเป็นตัวอักษรภาษาอังกฤษเท่านั้น';
        $rules[$inputName] = $ruleArray;
      } elseif ($inputName === 'email') {
        $rules[$inputName] = array_merge(
          $required ? ['required'] : ['nullable'],
          [
            'email',
            function ($attribute, $value, $fail) use ($allowedTLDs) {
              if (!$value) {
                return;
              }
              $domain = substr(strrchr($value, '@'), 1);
              if (
                !collect($allowedTLDs)->contains(
                  fn($suffix) => str_ends_with($domain, $suffix),
                )
              ) {
                $fail(
                  'รูปแบบอีเมลต้องลงท้ายด้วย .com, .net , .co.th , .ac.th, .or.th, .go.th, .edu หรือ .org เท่านั้น',
                );
              }
            },
          ],
        );
      } else {
        $ruleArray[] = 'string';
        $rules[$inputName] = $ruleArray;
      }
    }

    return ['rules' => $rules, 'messages' => $messages];
  }

  protected function getDefaultValidationRules($allowedTLDs)
  {
    return [
      'rules' => [
        'firstname' => 'required|string|regex:/^[A-Za-z ]+$/',
        'lastname' => 'required|string|regex:/^[A-Za-z ]+$/',
        'nickname' => 'required|string|regex:/^[A-Za-z ]+$/',
        'birthdate' => 'required|string',
        'schoolname' => 'required|string',
        'grade' => 'required|string',
        'package' => 'required|string',
        'parent' => 'required|string',
        'address' => 'required|string',
        'postcode' => 'required|string',
        'phone' => 'required|string',
        'email' => [
          'required',
          'email',
          function ($attribute, $value, $fail) use ($allowedTLDs) {
            $domain = substr(strrchr($value, '@'), 1);
            if (
              !collect($allowedTLDs)->contains(
                fn($suffix) => str_ends_with($domain, $suffix),
              )
            ) {
              $fail(
                'รูปแบบอีเมลต้องลงท้ายด้วย .com, .net , .co.th , .ac.th, .or.th, .go.th, .edu หรือ .org เท่านั้น',
              );
            }
          },
        ],
        'newsf' => 'required|string',
      ],
      'messages' => [
        'firstname.regex' => 'ชื่อต้องเป็นตัวอักษรภาษาอังกฤษเท่านั้น',
        'lastname.regex' => 'นามสกุลต้องเป็นตัวอักษรภาษาอังกฤษเท่านั้น',
        'nickname.regex' => 'ชื่อเล่นต้องเป็นตัวอักษรภาษาอังกฤษเท่านั้น',
      ],
    ];
  }

  // public function store(Request $request)
  // {
  //     return $this->storeFormManage($request);
  //     $allowedTLDs = ['.com', '.net', '.co.th', '.ac.th', '.or.th', '.go.th', '.edu', '.org'];
  //     $route = $request->get('routeName');

  //     $result = $this->checkRegisted(
  //         $route,
  //         $request->get('sfield'),
  //         $request->get('firstname'),
  //         $request->get('lastname'),
  //         $request->get('birthdate'),
  //         $request->get('phone'),
  //         $request->get('email'),
  //     );

  //     if ($result['checkRegisted']) {
  //         // 1) บล็อกกรณีข้อมูลซ้ำแบบตรงตัว
  //         if ($result['matchType'] === 'exact') {
  //             $message = "พบข้อมูลการลงทะเบียนซ้ำกับชื่อ-นามสกุล: {$result['receipt']->first_name} {$result['receipt']->last_name}\n";
  //             $message .= "กรุณาตรวจสอบข้อมูลของคุณ";
  //             return back()
  //                 ->withInput()
  //                 ->with('error', $message);
  //         }

  //         // 2) ชื่อคล้ายกัน: บล็อกเฉพาะเมื่อระบุได้ว่าเป็นคนเดียวกันจริง (วันเกิดตรง และ เบอร์และอีเมลตรง)
  //         if ($result['matchType'] === 'similar') {
  //             $similarity = number_format($result['similarity'] ?? 0, 2);
  //             if ($result['is_same_person']) {
  //                 $message = "พบข้อมูลการลงทะเบียนซ้ำ (ชื่อคล้าย {$similarity}% + วันเกิดตรง + เบอร์และอีเมลตรง) กับผู้ลงทะเบียนรายอื่น\n";
  //                 $message .= "ชื่อ-นามสกุล: {$result['receipt']->first_name} {$result['receipt']->last_name}\n";
  //                 $message .= "กรุณาตรวจสอบข้อมูลของคุณหรือใช้ข้อมูลติดต่ออื่น หากเป็นคนเดิม";
  //                 return back()
  //                     ->withInput()
  //                     ->with('error', $message);
  //             } else {
  //                 // ไม่ใช่คนเดียวกัน: เตือนและดำเนินการต่อ
  //                 // dd('ไม่ใช่คนเดียวกัน', $result);

  //                 $message = "พบข้อมูลชื่อหรือนามสกุลที่คล้ายกัน ({$similarity}%) กับผู้ลงทะเบียนรายอื่น\n";
  //                 $message .= "ชื่อ-นามสกุลที่พบ: {$result['receipt']->first_name} {$result['receipt']->last_name}\n";
  //                 $message .= "ระบบจะดำเนินการต่อ หากมั่นใจว่าไม่ใช่คนเดิม";
  //                 session()->flash('warning', $message);
  //             }
  //         }
  //     }

  //     // Build dynamic validation rules based on field_settings
  //     $validationData = $this->buildDynamicValidationRules($route, $allowedTLDs);
  //     $validator = Validator::make($request->all(), $validationData['rules'], $validationData['messages']);

  //     if ($validator->fails()) {
  //         //return response()->json(['errors' => $validator->errors()->all()]);
  //         return back()->withErrors(['errors' => $validator->errors()->all()]);
  //     }
  //     // dd($request);

  //     if (!file_exists(public_path() . '/receipt_form_images/')) {
  //         mkdir(public_path() . '/receipt_form_images/', 0777, true);
  //     }

  //     if (!file_exists(public_path() . '/receipt_form_watermark_images/')) {
  //         mkdir(public_path() . '/receipt_form_watermark_images/', 0777, true);
  //     }

  //     if ($request->get('sfield') == '17') {
  //         $filesa = (array) $request->get('imgFiles', []);
  //         $filesb = (array) $request->get('imgFiles2', []);

  //         $fileas = "";
  //         $filebs = "";

  //         foreach ($filesb as $fileb) {
  //             $oldfile = FileUpload::where('oldname', $fileb)->get();
  //             if ($oldfile->isEmpty()) {
  //                 continue;
  //             }

  //             $filebs .= $oldfile[0]->filename . "|";
  //             File::move(public_path() . '/form_images/' . $oldfile[0]->filename, public_path() . '/receipt_form_images/' . $oldfile[0]->filename);
  //             FileUpload::where('filename', $oldfile[0]->filename)->delete();
  //         }

  //         foreach ($filesa as $filea) {
  //             $oldfile = FileUpload::where('oldname', $filea)->get();
  //             if ($oldfile->isEmpty()) {
  //                 continue;
  //             }

  //             $fileas .= $oldfile[0]->filename . "|";
  //             File::move(public_path() . '/form_images/' . $oldfile[0]->filename, public_path() . '/receipt_form_images/' . $oldfile[0]->filename);
  //             FileUpload::where('filename', $oldfile[0]->filename)->delete();
  //         }

  //         $filebs = rtrim($filebs, "|");
  //         $fileas = rtrim($fileas, "|");
  //     } else {
  //         # code...
  //         $fileas = '';
  //         if ($request->has('imgFiles')) {
  //             $filesa = (array) $request->get('imgFiles', []);
  //             $fileas = "";
  //             foreach ($filesa as $filea) {
  //                 $oldfile = FileUpload::where('oldname', $filea)->get();
  //                 if ($oldfile->isEmpty()) {
  //                     continue;
  //                 }

  //                 $fileas .= $oldfile[0]->filename . "|";
  //                 File::move(public_path() . '/form_images/' . $oldfile[0]->filename, public_path() . '/receipt_form_images/' . $oldfile[0]->filename);

  //                 FileUpload::where('filename', $oldfile[0]->filename)->delete();
  //             }
  //             $fileas = rtrim($fileas, "|");
  //         }
  //         if ($request->get('sfield') == '23') {
  //             # code...
  //             $filebs = '';
  //         } else {
  //             $filebs = '';
  //             if ($request->has('imgFiles2')) {
  //                 $filesb = (array) $request->get('imgFiles2', []);
  //                 $filebs = "";
  //                 foreach ($filesb as $fileb) {
  //                     $oldfile = FileUpload::where('oldname', $fileb)->get();
  //                     if ($oldfile->isEmpty()) {
  //                         continue;
  //                     }

  //                     $filebs .= $oldfile[0]->filename . "|";
  //                     File::move(public_path() . '/form_images/' . $oldfile[0]->filename, public_path() . '/receipt_form_images/' . $oldfile[0]->filename);
  //                     FileUpload::where('filename', $oldfile[0]->filename)->delete();
  //                 }
  //                 $filebs = rtrim($filebs, "|");
  //             }
  //         }
  //     }

  //     if ($request->get('sfield') == 22 || $request->get('sfield') == 31 || $request->get('sfield') == 32) {
  //         # code...
  //         // Handle award as array and convert to JSON
  //         $awardInput = $request->get('award');
  //         if (is_array($awardInput)) {
  //             $award = json_encode($awardInput);
  //         } else {
  //             $award = $awardInput;
  //         }
  //         $street_address2 = $request->get('street_address2');
  //     } else {
  //         # code...
  //         $award = '';
  //         $street_address2 = '';
  //     }

  //     // Check Exam Mode Limits
  //     $formManage = FormManage::where('id', $request->get('sfield'))->first();
  //     $examMode = $request->get('exam_mode');
  //     $packageId = $request->get('package');

  //     // Check if selected package has exam mode enabled
  //     if ($packageId) {
  //         $selectedPackage = \App\Models\FormPakages::find($packageId);
  //         if ($selectedPackage && $selectedPackage->has_exam_mode) {
  //             // Validate exam_mode input
  //             if (!$examMode || !in_array($examMode, ['online', 'onsite'])) {
  //                 return back()->withInput()->with('error', 'กรุณาเลือกรูปแบบการสอบ (Online/Onsite)');
  //             }
  //         }
  //     }

  //     // Form-level exam mode check and limits
  //     if ($formManage && $formManage->enable_exam_mode && $examMode) {
  //         // Check form-level limits
  //         if ($examMode === 'online' && !$formManage->HasAvailableOnlineSlots()) {
  //             return back()->withInput()->with('error', 'ขออภัย ที่นั่งสอบ Online เต็มแล้ว');
  //         }
  //         if ($examMode === 'onsite' && !$formManage->HasAvailableOnsiteSlots()) {
  //             return back()->withInput()->with('error', 'ขออภัย ที่นั่งสอบ Onsite เต็มแล้ว');
  //         }
  //     }

  //     $receiptForm = new ReceiptForm([
  //         'sfield' => $request->get('sfield'),
  //         'submission_date' => date("Y-m-d"),
  //         'subject' => $request->get('subject'),
  //         'first_name' => $request->get('firstname'),
  //         'last_name' => $request->get('lastname'),
  //         'nick_name' => $request->get('nickname'),
  //         'gender' => $request->get('gender'),
  //         'birth_date' => $request->get('birthdate') ?? null,
  //         'ref_date' => $request->get('ref_date') ?? null,
  //         'school_name' => $request->get('schoolname'),
  //         'award' => $award ?? null,
  //         'street_address2' => $street_address2 ?? null,
  //         'grade' => $request->get('grade'),

  //         'package' => $request->get('package'),
  //         'package_id' => null, // This seems unused or null in original, keeping it.

  //         'contest' => $request->get('contest'),
  //         'discount_code' => $request->get('dcode'),
  //         'name_parent' => $request->get('parent'),
  //         'street_address' => $request->get('address'),
  //         'postcode' => $request->get('postcode'),
  //         'mobile' => $request->get('phone'),
  //         'email' => $request->get('email'),
  //         'news_form' => $request->get('newsf'),
  //         'photo_att' => $fileas,
  //         'file_att' => $filebs,
  //         'referent_code' => $request->get('referent_code'),
  //         'exam_mode' => $examMode, // Save exam mode
  //     ]);

  //     $receiptForm->save();

  //     // Update Registered Count for Form (form-level limits only)
  //     if ($formManage && $formManage->enable_exam_mode && $examMode) {
  //         if ($examMode === 'online') {
  //             $formManage->increment('online_registered');
  //         } elseif ($examMode === 'onsite') {
  //             $formManage->increment('onsite_registered');
  //         }
  //     }

  //     $adminEmail = $request->get('email');

  //     if (!in_array($request->get('sfield'), [0, 17], true) && $adminEmail) {
  //         if (filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
  //             Mail::to($adminEmail)->send(new ContactMail($receiptForm));
  //         }
  //     }
  //     // $receiptForm->save(); // Remove duplicate save

  //     if ($receiptForm) {
  //         return redirect('/form/complete/' . $route);
  //     } else {
  //         return back()->with('error', 'บันทึกข้อมูลไม่สำเร็จ กรุณาลองใหม่อีกครั้ง');
  //     }
  // }

  public function storeFormManage(Request $request)
  {
    \Illuminate\Support\Facades\Log::info('storeFormManage started', [
      'request' => $request->except([
        'imgFiles',
        'imgFiles2',
        'photo_att',
        'file_att',
      ]),
    ]);

    $allowedTLDs = [
      '.com',
      '.net',
      '.co.th',
      '.ac.th',
      '.or.th',
      '.go.th',
      '.edu',
      '.org',
    ];
    $route = $request->get('routeName');

    $result = $this->checkRegisted(
      $route,
      $request->get('sfield'),
      $request->get('firstname'),
      $request->get('lastname'),
      $request->get('birthdate'),
      $request->get('phone'),
      $request->get('email'),
    );
    // dd($request->all(), '0');

    if ($result['checkRegisted']) {
      \Illuminate\Support\Facades\Log::info('Duplicate registration detected', [
        'result' => $result,
      ]);

      // 1) บล็อกกรณีข้อมูลซ้ำแบบตรงตัว
      if ($result['matchType'] === 'exact') {
        \Illuminate\Support\Facades\Log::info('Duplicate exact match blocked', [
          'receipt' => $result['receipt'],
        ]);
        $message = "พบข้อมูลการลงทะเบียนซ้ำกับชื่อ-นามสกุล: {$result['receipt']->first_name} {$result['receipt']->last_name}\n";
        $message .= 'กรุณาตรวจสอบข้อมูลของคุณ';

        if ($request->ajax()) {
          return response()->json(['message' => $message], 422);
        }

        return back()->withInput()->with('error', $message);
      }

      // 2) ชื่อคล้ายกัน
      if ($result['matchType'] === 'similar') {
        $similarity = number_format($result['similarity'] ?? 0, 2);

        // 2.1) เป็นคนเดียวกัน (วันเกิด + เบอร์/อีเมล ตรงกัน) -> บล็อก
        if ($result['is_same_person']) {
          $message = "พบข้อมูลการลงทะเบียนซ้ำ (ชื่อคล้าย {$similarity}% + วันเกิดตรง + เบอร์และอีเมลตรง) กับผู้ลงทะเบียนรายอื่น\n";
          $message .= "ชื่อ-นามสกุล: {$result['receipt']->first_name} {$result['receipt']->last_name}\n";
          $message .=
            'กรุณาตรวจสอบข้อมูลของคุณหรือใช้ข้อมูลติดต่ออื่น หากเป็นคนเดิม';

          if ($request->ajax()) {
            return response()->json(['message' => $message], 422);
          }

          return back()->withInput()->with('error', $message);
        } else {
          // 2.2) ไม่ใช่คนเดียวกัน: เตือนและดำเนินการต่อ
          $message = "พบข้อมูลชื่อหรือนามสกุลที่คล้ายกัน ({$similarity}%) กับผู้ลงทะเบียนรายอื่น\n";
          $message .= "ชื่อ-นามสกุลที่พบ: {$result['receipt']->first_name} {$result['receipt']->last_name}\n";
          $message .= 'ระบบจะดำเนินการต่อ หากมั่นใจว่าไม่ใช่คนเดิม';
          session()->flash('warning', $message);
        }
      }
    }

    // Build dynamic validation rules based on field_settings
    $validationData = $this->buildDynamicValidationRules($route, $allowedTLDs);
    $validator = Validator::make(
      $request->all(),
      $validationData['rules'],
      $validationData['messages'],
    );

    if ($validator->fails()) {
      \Illuminate\Support\Facades\Log::warning('Form Validation Failed', [
        'errors' => $validator->errors()->all(),
        'request' => $request->all(),
      ]);

      if ($request->ajax()) {
        return response()->json(['errors' => $validator->errors()->all()], 422);
      }

      return back()->withErrors(['errors' => $validator->errors()->all()]);
    }
    // dd($request);

    if (!file_exists(public_path() . '/receipt_form_images/')) {
      mkdir(public_path() . '/receipt_form_images/', 0777, true);
    }

    if (!file_exists(public_path() . '/receipt_form_watermark_images/')) {
      mkdir(public_path() . '/receipt_form_watermark_images/', 0777, true);
    }

    if ($request->get('sfield') == '17') {
      $filesa = (array) $request->get('imgFiles', []);
      $filesb = (array) $request->get('imgFiles2', []);

      $fileas = '';
      $filebs = '';

      foreach ($filesb as $fileb) {
        $oldfile = FileUpload::where('oldname', $fileb)->get();
        if ($oldfile->isEmpty()) {
          continue;
        }

        $filebs .= $oldfile[0]->filename . '|';
        File::move(
          public_path() . '/form_images/' . $oldfile[0]->filename,
          public_path() . '/receipt_form_images/' . $oldfile[0]->filename,
        );
        FileUpload::where('filename', $oldfile[0]->filename)->delete();
      }

      foreach ($filesa as $filea) {
        $oldfile = FileUpload::where('oldname', $filea)->get();
        if ($oldfile->isEmpty()) {
          continue;
        }

        $fileas .= $oldfile[0]->filename . '|';
        File::move(
          public_path() . '/form_images/' . $oldfile[0]->filename,
          public_path() . '/receipt_form_images/' . $oldfile[0]->filename,
        );
        FileUpload::where('filename', $oldfile[0]->filename)->delete();
      }

      $filebs = rtrim($filebs, '|');
      $fileas = rtrim($fileas, '|');
    } else {
      # code...
      $fileas = null;
      if ($request->has('imgFiles')) {
        $filesa = (array) $request->get('imgFiles', []);
        $fileas = '';
        foreach ($filesa as $filea) {
          $oldfile = FileUpload::where('oldname', $filea)->get();
          if ($oldfile->isEmpty()) {
            continue;
          }

          $fileas .= $oldfile[0]->filename . '|';
          File::move(
            public_path() . '/form_images/' . $oldfile[0]->filename,
            public_path() . '/receipt_form_images/' . $oldfile[0]->filename,
          );

          FileUpload::where('filename', $oldfile[0]->filename)->delete();
        }
        $fileas = rtrim($fileas, '|');
      }
      if ($request->get('sfield') == '23') {
        # code...
        $filebs = null;
      } else {
        $filebs = null;
        if ($request->has('imgFiles2')) {
          $filesb = (array) $request->get('imgFiles2', []);
          $filebs = '';
          foreach ($filesb as $fileb) {
            $oldfile = FileUpload::where('oldname', $fileb)->get();
            if ($oldfile->isEmpty()) {
              continue;
            }

            $filebs .= $oldfile[0]->filename . '|';
            File::move(
              public_path() . '/form_images/' . $oldfile[0]->filename,
              public_path() . '/receipt_form_images/' . $oldfile[0]->filename,
            );
            FileUpload::where('filename', $oldfile[0]->filename)->delete();
          }
          $filebs = rtrim($filebs, '|');
        }
      }
    }

    if (
      $request->get('sfield') == 22 ||
      $request->get('sfield') == 31 ||
      $request->get('sfield') == 32
    ) {
      # code...
      // Handle award as array and convert to JSON
      $awardInput = $request->get('award');
      if (is_array($awardInput)) {
        $award = json_encode($awardInput);
      } else {
        $award = $awardInput;
      }
      $street_address2 = $request->get('street_address2');
    } else {
      # code...
      $award = '';
      $street_address2 = '';
    }

    $packageInput = $request->get('package');

    // Handle multi-select packages
    if (is_array($packageInput)) {
      $packageIds = [];
      $packageNames = [];

      foreach ($packageInput as $pkgId) {
        $formPackage = FormPakages::find($pkgId);
        if ($formPackage) {
          $packageIds[] = $formPackage->id;
          $packageNames[] = $formPackage->package;
        }
      }

      $package_id = !empty($packageIds) ? json_encode($packageIds) : null;
      $package = !empty($packageNames) ? implode(', ', $packageNames) : null;
    } else {
      // Handle single package selection
      $package_id = $packageInput;
      $formPackage = FormPakages::find($package_id);

      if ($formPackage) {
        # code...
        $package_id = $formPackage->id;
        $package = $formPackage->package;
      } else {
        # code...
        $package = $packageInput;
      }
    }

    // dd($request->all(), '1');
    // Check Exam Mode Limits
    $formManage = FormManage::find($request->get('sfield'));
    if ($formManage && $formManage->enable_exam_mode) {
      $examMode = $request->get('exam_mode');
      if (!$examMode) {
        $message = 'กรุณาเลือกรูปแบบการสอบ / Please select Exam Mode';
        if ($request->ajax()) {
          return response()->json(['message' => $message], 422);
        }
        return back()->withInput()->with('error', $message);
      }

      $currentCount = ReceiptForm::where('sfield', $request->get('sfield'))
        ->where('exam_mode', $examMode)
        ->count();

      $limit =
        $examMode == 'online'
          ? $formManage->online_limit
          : $formManage->onsite_limit;

      // If limit is set (not null) and greater than 0, check against count
      // Assumption: If limit is null, it's unlimited. If 0, no seats.
      if (!is_null($limit) && $currentCount >= $limit) {
        $modeLabel = $examMode == 'online' ? 'Online' : 'Onsite';
        $message = "ขออภัย ที่นั่งสอบรูปแบบ {$modeLabel} เต็มแล้ว / Sorry, {$modeLabel} exam seats are full.";

        if ($request->ajax()) {
          return response()->json(['message' => $message], 422);
        }

        return back()->withInput()->with('error', $message);
      }
    }

    $grade = FormGrades::find($request->get('grade'));
    // dd($request->all());

    $receiptForm = new ReceiptForm([
      'sfield' => $request->get('sfield'),
      'exam_mode' => $request->get('exam_mode'),
      'submission_date' => date('Y-m-d'),
      'generate' => 0,
      'subject' => $request->get('subject'),
      'first_name' => $request->get('firstname'),
      'middle_name' => $request->get('middlename'),
      'last_name' => $request->get('lastname'),
      'nick_name' => $request->get('nickname'),
      'gender' => $request->get('gender'),
      'birth_date' => $request->get('birthdate') ?? null,
      'ref_date' => $request->get('ref_date') ?? null,
      'school_name' => $request->get('schoolname'),
      'award' => $award ?? null,
      'street_address2' => $street_address2 ?? null,
      'grade' => $grade->grade,
      'package' => $package,
      'package_id' => $package_id,
      'contest' => $request->get('contest'),
      'discount_code' => $request->get('dcode'),
      'name_parent' => $request->get('parent'),
      'street_address' => $request->get('address'),
      'postcode' => $request->get('postcode'),
      'mobile' => $request->get('phone'),
      'email' => $request->get('email'),
      'news_form' => $request->get('newsf'),
      'photo_att' => $fileas,
      'file_att' => $filebs,
      'referent_code' => $request->get('referent_code'),
    ]);

    $receiptForm->save();

    \Illuminate\Support\Facades\Log::info(
      "ReceiptForm Saved. ID: {$receiptForm->id}, Route: {$route}",
    );

    $adminEmail = $request->get('email');

    if (!in_array($request->get('sfield'), [0, 17], true) && $adminEmail) {
      if (filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
        try {
          Mail::to($adminEmail)->send(new ContactMail($receiptForm));
          \Illuminate\Support\Facades\Log::info("Email sent to: {$adminEmail}");
        } catch (\Exception $e) {
          \Illuminate\Support\Facades\Log::error(
            "Failed to send email to {$adminEmail}: " . $e->getMessage(),
          );
        }
      }
    }
    // $receiptForm->save();

    if ($formManage && $formManage->enable_exam_mode && $examMode) {
      if ($examMode === 'online') {
        $formManage->increment('online_registered');
      } elseif ($examMode === 'onsite') {
        $formManage->increment('onsite_registered');
      }
    }

    $adminEmail = $request->get('email');

    if (!in_array($request->get('sfield'), [0, 17], true) && $adminEmail) {
      if (filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
        Mail::to($adminEmail)->send(new ContactMail($receiptForm));
      }
    }
    // $receiptForm->save(); // Remove duplicate save

    if ($receiptForm) {
      return redirect('/form/completed/' . $route);
    } else {
      return back()->with(
        'error',
        'บันทึกข้อมูลไม่สำเร็จ กรุณาลองใหม่อีกครั้ง',
      );
    }
  }

  public function reSendMail($id)
  {
    //
    $receiptForm = ReceiptForm::find($id);
    $adminEmail = $receiptForm->email;
    if (!in_array($receiptForm->sfield, [0, 17], true) && $adminEmail) {
      if (filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
        Mail::to($adminEmail)->send(new ContactMail($receiptForm));
      }
    }
    $receiptForm->save();
    return response()->json([
      'status' => 'success',
      'message' => 'Mail sent successfully',
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\ReceiptForm  $receiptForm
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request)
  {
    //
    return view('receipt_form.complete')->with(['sfield' => $request->sfield]);
  }
  public function showFormManage(Request $request)
  {
    //
    return view('receipt_form.complete_formManage')->with([
      'sfield' => $request->sfield,
    ]);
  }
  public function show1(ReceiptForm $receiptForm)
  {
    //
    return view('receipt_form.complete1');
  }
  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\ReceiptForm  $receiptForm
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
    //
    $this->check_permission();
    $data = ReceiptForm::find($id);

    $photo_att = '';

    if ($data->photo_att) {
      $arrl = explode('|', $data->photo_att);
      for ($i = 0; $i <= count($arrl) - 1; $i++) {
        //$urla = "https://" . $arrl[$i];
        $urla = url('/') . '/receipt_form_images/' . $arrl[$i];
        //$retu = $this->get_img_url($urla);
        //if ($this->URL_exists($retu)) {
        $photo_att .=
          "<div><img src=\"" .
          $urla .
          "\" height=\"80\"></div>&nbsp;&nbsp;
                <a class='btn btn-xs btn-info btn-view' href=\"" .
          urldecode($urla) .
          "\" target=\"blank\"><i class='fa fa-search'></i></a>";
        //}
      }
    }
    // dd($urla);
    // dd($data);

    $file_att = '';
    $furl = '';
    if ($data->file_att) {
      $arrf = explode('|', $data->file_att);
      for ($j = 0; $j <= count($arrf) - 1; $j++) {
        //$urla = "https://" . $arrl[$i];
        $urlb = url('/') . '/receipt_form_images/' . $arrf[$j];

        //watermark
        $fileex = explode('/', $urlb);
        $this->textWatermark(
          end($fileex),
          'Date Register : ' . $data->submission_date,
        );
        $urlb = str_replace(
          'receipt_form_images',
          'receipt_form_watermark_images',
          $urlb,
        );

        //$retu = $this->get_img_url($urla);
        //if ($this->URL_exists($retu)) {
        $file_att .=
          "<div><img src=\"" .
          $urlb .
          "\" height=\"80\"></div>&nbsp;&nbsp;
                <a class='btn btn-xs btn-info btn-view' href=\"" .
          urldecode($urlb) .
          "\" target=\"blank\"><i class='fa fa-search'></i></a><a href='#' class='btn btn-xs btn-danger btn-edit' id='getDeleteData' data-id2='" .
          $data->id .
          "' data-id='" .
          $arrf[$j] .
          "'><i class='fa fa-trash'></i></a><br><br>";
        //}
        $furl .= $urlb;
      }
    }

    $data->photo = $photo_att;
    $data->file = $file_att;

    $data->file_re = $furl;

    if ($data->generate == 0) {
      $data->rnumber = Receipt_RunningNumber::pre_generate(
        $data->sfield,
        $data->submission_date,
      );
    } else {
      $data->rnumber = '';
    }

    $packages = FormPakages::find($data->package);

    if ($packages) {
      $data->package = $packages->package;
      $data->packageId = $packages->id;
    } else {
      $data->packageId = '';
    }

    // Decode award JSON if it exists
    if ($data->award && is_string($data->award)) {
      $decodedAward = json_decode($data->award, true);
      if (json_last_error() === JSON_ERROR_NONE && is_array($decodedAward)) {
        $data->award = $decodedAward;
      }
    }

    $data->ref_date_label = optional($data->formManage)->ref_date_label
      ? optional($data->formManage)->ref_date_label . ' : '
      : 'Reference Date :';
    // dd($data);
    return response()->json([
      'data' => $data,
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\ReceiptForm  $receiptForm
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    //
    // dd($request->all());

    $this->check_permission();

    $img = $request->get('img');
    $stu = '';
    $urlbr = '';

    if ($img != null || $img != '') {
      foreach ($img as $fileb) {
        //echo $filea;
        // $stu .= $sss . "|";
        $oldfile = FileUpload::where('oldname', $fileb)->get();
        $stu .= $oldfile[0]->filename . '|';
        File::move(
          public_path() . '/form_images/' . $oldfile[0]->filename,
          public_path() . '/receipt_form_images/' . $oldfile[0]->filename,
        );

        $urlb = url('/') . '/receipt_form_images/' . $oldfile[0]->filename;

        //watermark
        $fileex = explode('/', $urlb);
        $this->textWatermark(
          end($fileex),
          'Date Register : ' . $request->get('submission_date'),
        );
        $urlbr .=
          str_replace(
            'receipt_form_images',
            'receipt_form_watermark_images',
            $urlb,
          ) . '|';

        FileUpload::where('filename', $oldfile[0]->filename)->delete();
      }
    }

    $dataimg = ReceiptForm::find($request->get('fid'));
    if ($dataimg->file_att != null && $dataimg->file_att != '') {
      $stu = $dataimg->file_att . '|' . $stu;
    }
    $stu = rtrim($stu, '|');

    $datare = Receipt::where('recform_id', $request->get('fid'))->first();
    if ($datare && $datare->file_att != null && $datare->file_att != '') {
      $urlbr = $datare->file_att . $urlbr;
    }
    $urlbr = rtrim($urlbr, '|');

    // dd($datare->file_att,$urlbr);
    if ($datare) {
      $datare->update(['file_att' => $urlbr]);
    }
    ReceiptForm::find($request->get('fid'))->update(['file_att' => $stu]);

    $validator = Validator::make($request->all(), [
      'first_name' => 'required|string',
      'last_name' => 'required|string',
      'nick_name' => 'required|string',
      'birth_date' => 'required|string',
      'school_name' => 'required|string',
      'grade' => 'required|string',
      'package' => 'required|string',
      'name_parent' => 'required|string',
      'street_address' => 'required|string',
      'postcode' => 'required|string',
      'mobile' => 'required|string',
      'email' => 'required|email',
      'news_form' => 'required|string',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()->all()]);
    }

    // Prepare update data
    $updateData = $request->all();

    // Handle award field if present
    if ($request->has('award')) {
      $awardInput = $request->get('award');
      if (is_array($awardInput)) {
        $updateData['award'] = json_encode($awardInput);
      }
    }

    ReceiptForm::find($request->get('fid'))->update($updateData);
    return response()->json(['success' => 'Receipt Form updated successfully']);
  }

  public function exportForm(Request $request)
  {
    // dd($request);

    if ($request->excel === '1') {
      # code...
      return Excel::download(
        new ExportExcel(
          $request->get('sfield'),
          $request->get('table_records'),
        ),
        'ReceiptForm.xlsx',
      );
    } else {
      # code...
      return Excel::download(
        new ExportForm($request->get('sfield'), $request->get('table_records')),
        'Registerform.xlsx',
      );
    }
  }

  public function deleteImg($id, $id2)
  {
    $dataimg = ReceiptForm::find($id2);
    $receipt = Receipt::where('recform_id', $id2)->first();

    $img = $dataimg->file_att ? explode('|', $dataimg->file_att) : [];
    $receiptimg = $receipt->file_att ?? '';

    $baseUrl = url('/');
    $receiptimg = preg_split(
      '/(?=' . preg_quote($baseUrl, '/') . ')/',
      $receiptimg,
      -1,
      PREG_SPLIT_NO_EMPTY,
    );

    // ลบรูปจาก ReceiptForm
    $idFile = basename($id); // ชื่อไฟล์ เช่น abc.png

    foreach ($img as $key => $value) {
      if (str_contains($value, $idFile)) {
        unset($img[$key]);
      }
    }

    foreach ($receiptimg as $key => $value) {
      if (str_contains($value, $idFile)) {
        unset($receiptimg[$key]);
      }
    }

    // อัปเดตกลับ DB
    $dataNew = implode('|', $img);
    $receiptNew = implode('|', $receiptimg);

    $dataimg->update(['file_att' => $dataNew]);
    $receipt->update(['file_att' => $receiptNew]);

    $link = url('/') . '/receipts_form/' . $id;

    $html = '';
    $pic = explode('|', $dataNew);
    foreach ($pic as $pics) {
      if ($pics != null && $pics != '') {
        /*  $html .= '
                <div class="col-md-4 text-center mb-3 ">
                <img src="' . url('/') . '/receipts_form/' . $pics . '" class=" mt-5 mb-3" height="400" width="300">
                <a href="#" class="btn btn-xs btn-danger btn-edit" id="getDeleteData" data-id2="' . $id2 . '" data-id="' . $pics . '">delete </a>
                </div>
                '; */
        $this->textWatermark(
          $pics,
          'Date Register : ' . $dataimg->submission_date,
        );
        //$urlb = str_replace('receipt_form_images', 'receipt_form_watermark_images', $urlb);

        $html .=
          "<div><img src=\"" .
          url('/') .
          '/receipt_form_watermark_images/' .
          $pics .
          "\" height=\"80\"></div>&nbsp;&nbsp;
                <a class='btn btn-xs btn-info btn-view' href=\"" .
          urldecode(url('/') . '/receipt_form_watermark_images/' . $pics) .
          "\" target=\"blank\"><i class='fa fa-search'></i></a><a href='#' class='btn btn-xs btn-danger btn-edit' id='getDeleteData' data-id2='" .
          $id2 .
          "' data-id='" .
          $pics .
          "'><i class='fa fa-trash'></i></a><br><br>";
      } else {
        $html = '';
      }
    }
    return response()->json(['imgs' => $html]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\ReceiptForm  $receiptForm
   * @return \Illuminate\Http\Response
   */
  public function destroy_func($id)
  {
    //
    // dd($id);

    $oldfile = ReceiptForm::find($id);
    // dd($oldfile);

    if ($oldfile->generate == 0) {
      $arrl = explode('|', $oldfile->photo_att);
      if ($oldfile->photo_att) {
        # code...

        for ($i = 0; $i < count($arrl); $i++) {
          $path = public_path() . '/receipt_form_images/' . $arrl[$i];
          // echo "Attempting to delete: $path\n"; // Debug output

          if (file_exists($path)) {
            if (!is_dir($path)) {
              unlink($path);
              // echo "Deleted: $path\n"; // Debug output
            } else {
              // echo "Skipping directory: $path\n"; // Debug output
            }
          } else {
            // echo "File does not exist: $path\n"; // Debug output
          }
        }
      }

      if ($oldfile->sfield === '23') {
        # code...
      } else {
        # code...

        if ($oldfile->file_att) {
          # code...
          $arrb = explode('|', $oldfile->file_att);
          for ($j = 0; $j <= count($arrb) - 1; $j++) {
            $path = public_path() . '/receipt_form_images/' . $arrb[$j];
            if (file_exists($path)) {
              unlink($path);
            }
          }
        }
      }

      //print_r($oldfile);

      ReceiptForm::where('id', $id)->delete();
    }
  }

  public function destroy($id)
  {
    //
    // dd($id);
    $this->check_permission();
    $this->destroy_func($id);
    return ['success' => true, 'message' => 'Deleted Successfully'];
  }

  public function destroy_all(Request $request)
  {
    $this->check_permission();
    $arr_del = $request->get('table_records'); //$arr_ans is Array MacAddress

    for ($xx = 0; $xx < count($arr_del); $xx++) {
      $this->destroy_func($arr_del[$xx]);
    }
    //$ids = $request->get('table_records');
    //User::whereIn('id',explode(",",$ids))->delete();
    //return redirect('/receipt/?id=' . $request->get('id'))->with('success', 'Deleted Successfully');
    return redirect('/receipts_form/?sfield=' . $request->get('sfield'))->with(
      'success',
      'Deleted Successfully',
    );
  }
}
