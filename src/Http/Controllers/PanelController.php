<?php

namespace Fpaipl\Panel\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class PanelController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public $model;
    public $datatable;
    public $modelName;
    public $messages;
    public $fields;
    public $param;
    public $returnURL;

    public function __construct($datatable, $model, $param, $returnURL)
    {
        $this->model = $model;
        $this->datatable = $datatable;
        $this->param = $param;
        $this->returnURL = $returnURL;

        $this->messages = $datatable->getMessages();
        $this->modelName =$datatable->getModelName(); 
        $this->fields = $datatable->getfields()->toArray(); 
    }

    public function index()
    {
        if ($this->model::INDEXABLE()) {
            return view('panel::lists.index', [
                'model' => $this->model, 
                'datatable' => get_class($this->datatable),
                'messages' => $this->messages,
                'modelName' => $this->modelName
            ]);
        } 
        session()->flash('toast', [
            'class' => 'warning',
            'text' => $this->messages['under_dev']
        ]);
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($this->model::CREATEABLE()) {
            return view('panel::forms.model-crud', [
                'model' => null, 
                'formType' => __FUNCTION__,
                'fields' => $this->fields,
                'modelName' => $this->modelName,
                'messages' => $this->messages
            ]);
        }
        session()->flash('toast', [
            'class' => 'warning',
            'text' => $this->messages['under_dev']
        ]);
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        if ($this->model::EDITABLE()) {

            $model = $this->model::where('slug', $request->route()->parameters()[$this->param])->firstOrFail();

            return view('panel::forms.model-crud', [
                'model' => $model, 
                'formType' => __FUNCTION__,
                'fields' => $this->fields,
                'modelName' => $this->modelName,
                'messages'  => $this->messages,
                'current_page_no' => $request->page
            ]);
        }
        session()->flash('toast', [
            'class' => 'warning',
            'text' => $this->messages['under_dev']
        ]);
        return redirect()->back();
    }
    
    //It show the record
    public function show(Request $request, )
    {
        if ($this->model::VIEWABLE()) {
            $model = $this->model::where('slug', $request->route()->parameters()[$this->param])->withTrashed()->firstOrFail();

            return view('panel::forms.model-crud', [
                'model' => $model, 
                'formType' => __FUNCTION__,
                'fields' => $this->fields,
                'modelName' => $this->modelName,
                'messages'  => $this->messages,
                'current_page_no' => $request->page
            ]);
        }
        session()->flash('toast', [
            'class' => 'warning',
            'text' => $this->messages['under_dev']
        ]);
        return redirect()->back();
    }
       
    /*
       It open the delete form
    */
    public function advance_delete(Request $request)
    {
        $model = $this->model::where('slug', $request->route()->parameters()[$this->param])->firstOrFail();

        return view('panel::forms.model-crud' , [
            'model' => $model,
            'modelClass' => $this->model, 
            'datatable' => get_class($this->datatable),
            'formType' => __FUNCTION__,
            'modelName' => $this->modelName,
            'returnURL' => $this->returnURL
        ]);
    }

}
