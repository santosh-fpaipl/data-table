<?php

namespace Fpaipl\Panel\Http\Livewire;
use Livewire\Component;
use Route;
use App\Models\CartProduct;
use App\Event\CartProductDeleteEvent;

class Delete extends Component
{
    public $formType;
    
    public $recordId;

    public $model;

    public $modelClass;

    public $messages;
    
    protected $datatable;
    
    public $modelName;

    public $datatableClass;

    public $returnURL;

    public $page;

    public $confirm;

    public $cartProducts = [];

    protected $queryString = ['page'];

    public function mount()
    {
       
        $this->recordId = $this->model->id;

        $this->datatable = new $this->datatableClass();
        
        // It have model name only.
        $this->modelName = $this->datatable->getModelName();

        $this->messages = $this->datatable->getMessages();

        if(get_class($this->model) == 'App\Models\Product'){
            $cartProduct = $this->model->inCart();
            if($cartProduct['total']){
                $this->cartProducts = $cartProduct['cartProducts'];
                $this->confirm = true;
            } else {
                $this->confirm = false;
            }
        } else {
            $this->confirm = false;
        }
    }

    public function confirm(){
        foreach(CartProduct::with('cart')->with('colorSize')->whereIn('id', $this->cartProducts)->get() as $index => $cartProduct){
            /**
            * Dispatch an event
            */
            if(!empty($cartProduct->cart->user
                && !empty($cartProduct->colorSize->color->product->name)
                && !empty($cartProduct->colorSize->color->name)
                && !empty($cartProduct->colorSize->size->name)
            )){
                CartProductDeleteEvent::dispatch(
                    $cartProduct->cart->user,
                    $cartProduct->colorSize->id,
                    $cartProduct->quantity,
                );
                
                $cartProduct->delete();
            }
        }
        $this->delete();
    }

    public function delete()
    {
        if ($this->modelClass::softDeleteModelWithRelation([$this->recordId], $this->model)) {
            session()->flash('toast', [
                'class' => 'success',
                'text' => $this->messages['delete_success']
            ]);
        }
        return redirect()->route($this->returnURL,['page'=>$this->page,'from'=>'crud']);
    }

    public function render()
    {
        return view('panel::livewire.delete');
    }
}
