<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\WebContents;
use App\Helpers\CustomHelperFunctions;
use Excel;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('dashboard.home');
    }

    /**
     * Created By : Dinesh
     * Purpose    : Fetches all the news items in the DB
     * Created on : May 23 2018 
     */
    public function getAllNews(Request $request) {

        $news = WebContents::paginate(5);
        $data['paginationString'] = CustomHelperFunctions::getPaginationString($news);
        $data['totalNews'] = $news->total();
        $latest_news = $news->toArray();
        $data['latestNews'] = $latest_news['data'];
        $data['pagination'] = $news;
        return view('dashboard.newsDetails', $data);
    }

    /**
     * Created By : Dinesh
     * Purpose    : Fetches content of a news by id
     * Created on : May 23 2018 
     */
    public function news($id) {

        $news_content = WebContents::getContentById($id);
        $data['newsContent'] = trim($news_content);

        return view('dashboard.news', $data);
    }

    /**
     * Created By : Dinesh
     * Purpose    : Generates csv or the json file depending on the request
     * Created on : May 24 2018 
     */
    public function exportFile(Request $request) {
        $fileType = $request->get('filetype');
        $news = WebContents::all()->toArray();
        $fileName = "LatestNews" . time();

        if ($fileType == 'csv') {

            $exceData['header'] = array('Title', 'Content', 'Images URL'); // Heading for the excel file
            $exceData['data'] = $news;

            Excel::create($fileName, function($excel) use( $exceData) {
                $excel->sheet('news_Data', function($sheet) use($exceData) {
                    $sheet->loadView('report.newsReport', $exceData);
                });
            })->export('xls');
        } else {

            return response($news, 200, [
                'Content-Type' => 'application/json',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '.json"',
            ]);
        }
    }

}
