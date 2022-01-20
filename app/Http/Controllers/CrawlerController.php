<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Symfony\Component\DomCrawler\Crawler;

class CrawlerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = [];
		$urls = $request->urls;
		$pathToImage = 'public/shotdir/shot'.date('Ymdhisu').'.jpg';
		foreach ($urls as $url) {
			if(empty($url)) continue;
			$html = file_get_contents($url);
			$crawler = new Crawler($html);
			$data['url'] = $url;
			$data['title'] = $crawler->filter('title')->text();
			$description = $crawler->filterXpath("//meta[@name='description']")->extract(array('content'));
			$data['description'] = isset($description[0]) ? $description[0] : '';
			Browsershot::url($url)->save($pathToImage);
			$data['image'] = $pathToImage;
			$data['created_at'] = date('Y-m-d H:i:s');
			$result[] = $data;
		}

		return $result;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
