<?php

class JudgementController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$wheres = array(
			'name' => Input::get('name'),
			'court' => Input::get('court'),
			'year' => Input::get('year'),
			'case' => Input::get('case'),
			'no' => Input::get('no'),
			'date' => array(Input::get('from'), Input::get('to')),
			'cause' => Input::get('cause')
		);

		$judgements = new Judgement;

		foreach($wheres as $key => $val) {
			switch ($key) {
				case 'date':
					if($val[0] && $val[1]) {
						$judgements = $judgements->whereBetween('date', $val);
					}
					break;

				default:
					if($val) {
						$judgements = $judgements->where($key, 'LIKE' , "%$val%");
					}
					break;
			}
		}

		$judgements = $judgements->get();

		return Response::json(array(
        'error' => false,
        'judgements' => $judgements->toArray()),
        200
    	);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
