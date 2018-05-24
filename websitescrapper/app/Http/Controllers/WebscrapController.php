<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use App\Http\Requests;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;
use Image;
use App\WebContents;
use App\Cronlogs;
use ErrorException;

class WebscrapController extends Controller {

    public function __construct() {
        /* folder path to store scrapped images */
        $this->folder = 'images' . DIRECTORY_SEPARATOR . 'website';

        /* initilizing scrapper client */
        $this->client = new Client();
        $guzzleClient = new GuzzleClient(array(
            'curl' => array(
                CURLOPT_TIMEOUT => 60,
                CURLOPT_SSL_VERIFYPEER => false
            ),
        ));
        $this->client->setClient($guzzleClient);

        /* website to scrap */
        $this->websiteUrl = "http://www.cricbuzz.com/";

        $this->error = "";
    }

    /**
     * Created By : Dinesh
     * Purpose    : Scrapping content from a given website
     * Created on : May 23 2018 
     */
    public function index() {

        $crawler = $this->client->request('GET', $this->websiteUrl);

        /* finding the side navigation bar css class to fetch Latest news section */
        $crawler = $crawler->filter('#cb-news-blck')->filter('.cb-hm-lft');

        /* Traversing through each news */
        $crawler->filter('.cb-lst-itm')->each(function ($node, $key) {

            /* storing the title in the DB */
            $content = WebContents::create([
                        'title' => $node->filter('a')->text(),
                        'content' => ''
            ]);
            $contentId = $content->web_contents_id;
            $link = $node->filter('a')->attr('href');

            /* scrapping content of each news link */
            $crawler = $this->client->request('GET', $link);
            $linkSrc = $crawler->html();

            /* Fetching all the img elements in the scrapped content */
            $resultImages = $crawler
                    ->filterXpath('//img')
                    ->extract(array('src'));
            $i = 0;
            $imageSrc = [];

            /* Traversing through each image element */
            foreach ($resultImages as $image) {
                if ($image != "") {
                    $filePath = $this->folder . DIRECTORY_SEPARATOR . $contentId . "_" . basename($image);

                    $path = public_path() . DIRECTORY_SEPARATOR . $filePath;

                    try {
					/* Fix for images url which dont have http string in it*/
						if(!stristr($image,"http"))
							{
							$image = "http:".$image;
							}
                        /* Fetching image content and storing in the destination path */
                        $file = file_get_contents($image);
                        $insert = file_put_contents($path, $file);

                        /* Storing origional and new path of images in array */
                        $imageSrc[$i]['origional'] = $image;
                        $imageSrc[$i]['newUrl'] = url($filePath);
                        ;
                    } catch (ErrorException $e) {
                        $this->error .= $e->getmessage();
                    }

                    $i++;
                }
            }
            $linkImageUrls = "";
            /* Replacing origional path of the images in the scrapped content with new path */
            if (count($imageSrc) > 0) {
                foreach ($imageSrc as $image) {
                    $linkSrc = str_replace($image['origional'], $image['newUrl'], $linkSrc);
                }
                $linkImageUrls = implode(',', array_column($imageSrc, 'newUrl'));
            }
            /* Storing the scrapped content into DB */
            WebContents::find($contentId)->update(['content' => $linkSrc, 'image_urls' => $linkImageUrls]);
        });
        /* Storing cron logs into DB */
        Cronlogs::create(['log_error' => $this->error]);
        dd("Execution completed");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
