<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Models\Size;
use App\Models\Taxation;



function createBreadcrum($modelName, $formType){

    return '<nav style="--bs-breadcrumb-divider: \'>\';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="'.route(Str::plural($modelName) . '.index',['page'=>request()->query('page'),'from' =>'crud' ]).'">
                    '.ucwords($modelName).'
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">'.ucwords($formType).'</li>
        </ol>
    </nav>';
}

function getTableRowId($currentPage, $pageLength, $serial)
{
    return (($currentPage * $pageLength) - $pageLength) + $serial;
}

function checkCategoryLevel()
{
    $categoryLevel = 10;
    if ($categoryLevel == 1) {
        return false;
    } else if (session()->get('category_level') < $categoryLevel) {
        return true;
    }

    return false;
}

function changeDateFormate($value)
{

    return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d-m-Y h:i:s A');
}


function replaceKeyName($array, $oldKey, $newKey) {
    $array[$newKey] = $array[$oldKey];
    unset($array[$oldKey]);
    return $array;
}

function getTaxationName($model){
    $taxation= Taxation::findOrFail($model->taxation_id);
    return $taxation->name;
}

function getParentName($model, $key)
{
    return $model->{__FUNCTION__}($key);
}

function getUserData($model, $key)
{
    return $model->{__FUNCTION__}($key);
}


function getFamilyName($model)
{
    $array_of_names = array();
    array_push($array_of_names, $model->name);
    if (!empty($model->parent_id)) {
        array_push($array_of_names, implode("&nbsp;|&nbsp;", getParent($model)));
    }
    return implode("&nbsp;|&nbsp;", $array_of_names);
}

function getParent($parentModel)
{
    $names = [];
    if ($parentModel->parentWithTrashed) {
        $names[] = $parentModel->parentWithTrashed->name;
        if (!empty($parentModel->parentWithTrashed->parent_id)) {
            $names = array_merge($names, getParent($parentModel->parentWithTrashed));
        }
    }
    return $names;
}

function checkCurrentRoute($name)
{   
    $allRoutes = getRoutesArray();
    if (in_array(Route::currentRouteName() ,$allRoutes[$name])) {
        return 'active';
    }
}

function getRoutesArray():array
{
    return array(
        
        'dashboard' =>[
            'home',
        ],
        'user' => [
            'users.index',
            'users.show',
            'user.delete',
            'user.import.form',
            'user.import',
            'user.export',
        ],
        'profile' => [
            'profiles.index',
            'profiles.show',
            'profiles.delete',
            'profiles.import.form',
            'profiles.import',
            'profiles.export',
        ],
        'category' => [
            'categories.index',
            'categories.create',
            'categories.store',
            'categories.show',
            'categories.edit',
            'categories.update',
            'category.delete',
            'category.import.form',
            'category.import',
            'category.export',
        ],
        'product' => [
            'products.index',
            'products.create',
            'products.store',
            'products.show',
            'products.edit',
            'products.update',
            'product.delete',
            'product.import.form',
            'product.import',
            'product.export',
        ],
        'order' => [
            'orders.index',
            'orders.show',
            'orders.delete',
            'orders.export',
        ],
        'delivery' => [
            'deliveries.index',
            'deliveries.show',
            'deliveries.delete',
            'deliveries.export',
        ],
        'payment' => [
            'payments.index',
            'payments.show',
            'payments.delete',
            'payments.export',
        ],
        'collection' => [
            'collections.index',
            'collections.create',
            'collections.store',
            'collections.show',
            'collections.edit',
            'collections.update',
            'collection.delete',
            'collection.import.form',
            'collection.import',
            'collection.export',
        ],
        
    );
}

/**
 * Convert db timestamp in to string m-d-y
 */
function getTimestamp($value) {
    return date('m-d-Y',strtotime($value));
}

// function isTimestamp($field){
//     return Str::afterLast($field, '_') == 'at';
// }

// function isRelation($field){
//     return Str::afterLast($field, '_') == 'id';
// }

// function getFieldType($field){
//     if(isRelation($field)){
//        return 'relation';
//     } else if(isTimestamp($field)){
//         return 'timestamp';
//     }  else {
//         return 'default';
//     }
// }