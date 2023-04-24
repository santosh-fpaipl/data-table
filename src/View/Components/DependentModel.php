<?php

namespace Fpaipl\Features\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Str;

class DependentModel extends Component
{
    public $model;
    public $dependentRecordCount;
    public $dependentRecords = array();
   

    /**
     * Create a new component instance.
     */
    public function __construct($model) {
       $this->model = $model;
       $this->dependentRecordCount=0;
       $this->checkDependentModel();
    }

    public function checkDependentModel(){

        if (!empty($this->model)) {
            if($this->model->hasDependency()){
                foreach($this->model->getDependency() as $dependency){
                    if($this->model->$dependency->count()){
                     $modelName =  Str::of(get_class($this->model->$dependency->first()))->afterLast('\\');
                     $this->dependentRecordCount += $this->model->$dependency->count();
                      //$this->dependentRecords[$dependency] = $this->model->$dependency->count();
                      $this->dependentRecords[strtolower($modelName)] = $this->model->$dependency->count();
                    }
                }
            }
        }    

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('features::components.dependent-model');
    }
}
