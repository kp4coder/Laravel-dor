<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Page;
use App\Models\BookDor;
use App\Models\DoorStyle;
use App\Models\DoorType;
use App\Models\DoorTemplate;
use App\Models\GlassThickness;
use App\Models\GlassType;
use App\Models\Handle;
use App\Models\HardwareFinish;
use App\Models\ExtraOptionImage;


class MainController extends Controller
{
    //
    public function index() {

        $doorStyle = DoorStyle::query()->orderBy('order', 'asc')->get();
        $doorType = DoorType::query()->orderBy('order', 'asc')->get();
        $doorTemplate = DoorTemplate::with('doorStyle')->with('doorType')->orderBy('order', 'asc')->get();
        $glassThickness = GlassThickness::query()->orderBy('order', 'asc')->get();
        $hardwareFinish = HardwareFinish::query()->orderBy('order', 'asc')->get();
        $extraOptionImage = ExtraOptionImage::all();
        // $handle = Handle::query()->orderBy('order', 'asc')->get();
        // $glassType = GlassType::query()->orderBy('order', 'asc')->get();

        $glassType = GlassType::with('glassThickness')->get();
        $handle = Handle::with('hardwareFinish')->get();

        return view('front.home', compact('doorStyle', 'doorType', 'doorTemplate', 'glassThickness', 'glassType', 'handle', 'hardwareFinish', 'extraOptionImage') )->render();
    }

    public function page(Request $request, $url) {

        $page = Page::select('*')->where('slug', $url)->first();
        if (!$page) return die('URIS '.$url.' not found'); //
        return view('front.page', compact('page') )->render(); 
    }

    public function bookDor(Request $request) {
        

        $dor_request = $request->post();

        $validator = \Validator::make($dor_request, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'zip' => 'required'
        ],[
            'name.required' => 'Name is required.',
            'phone.required' => 'Phone is required.',
            'email.required' => 'E-mail is required.',
            'email.regex' => 'E-mail is not valid.',
            'zip.required' => 'Zip is required.',
        ]);

        if ($validator->fails()) { 
            return response()->json([
                    'status' => 'error',
                    'message' => 'Please fill the required fields.',
                ]);
            // return redirect()->back()->withErrors($validator)->withInput();
        }

        // Insert data into database
        $book = new BookDor();
        $book->style = $dor_request['style'];
        $book->door_type = $dor_request['door_type'];
        $book->template = $dor_request['template'];
        $book->measurements = $dor_request['measurements'];
        $book->thickness = $dor_request['thickness'];
        $book->glass_type = $dor_request['glass_type'];
        $book->hardware = $dor_request['hardware'];
        $book->handle = $dor_request['handle'];
        $book->name = $dor_request['name'];
        $book->address = $dor_request['address'];
        $book->phone = $dor_request['phone'];
        $book->city = $dor_request['city'];
        $book->email = $dor_request['email'];
        $book->zip = $dor_request['zip'];
        $book->comments = $dor_request['comments'];
        $book->save(); // Assign other fields as needed
        $bookId = $book->id;

        $book->data_style = DoorStyle::find($dor_request['style'])->first();
        $book->data_door_type = DoorType::find($dor_request['door_type'])->first();
        $book->data_template = DoorTemplate::find($dor_request['template'])->first();
        $book->data_thickness = GlassThickness::find($dor_request['thickness'])->first();
        $book->data_glass_type = GlassType::find($dor_request['glass_type'])->first();
        $book->data_hardware = HardwareFinish::find($dor_request['hardware'])->first();
        $book->data_handle = Handle::find($dor_request['handle'])->first();

        if (isset($dor_request['email']) && !empty($dor_request['email']) ) {
            
            $to = $dor_request['email'];
            $admin = setting('admin.admin_email');

            $message = view('front.email', compact('book'));

            $headers = 'From: no-reply@misalb66.com' . "\r\n" .

                'Reply-To: no-reply@misalb66.com' . "\r\n" .

                'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            'X-Mailer: PHP/' . phpversion();

            mail($to, 'Door: Recieved a request', $message, $headers);
            mail($admin, 'Door: Recieved a request', $message, $headers);

            // Mail::send('email.reserve', ['reserveform' => $reserveform], 
            //     function ($message) use ($reserveform) {

            //         $to = $reserveform['email']; // setting('contact.email-send');

            //         $message->to($to)->subject('samenop30: Maak uw reservering compleet');

            // }); 

            // if (Mail::failures()) {

            //     die(print_r(Mail::failures()));

            // } 

        }   
        
        return response()->json([
            'status' => 'success',
            'message' => 'Your shower details have been sent through to our team and a sales representative will be in touch to answer any questions you may have.',
            'bookId' => $bookId,
        ]);

        // return redirect()->back()->with('success', 'Your shower details have been sent through to our team and a sales representative will be in touch to answer any questions you may have.');
    }
}
