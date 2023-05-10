<?php

namespace Fpaipl\Panel\Traits;

trait ManageModel
{
    public static function softDeleteModel(array $records, string $model): String
    {
        $hasDependentRecord = false;

        if (!empty($records)) {
            foreach($records as $record){
                $Model = $model::findorfail($record);
                if($Model->hasDependency()){
                    foreach($Model->getDependency() as $dependency){
                        if($Model->$dependency->count()){
                            $hasDependentRecord = true;
                            break;
                        }
                    }
                }
                if($hasDependentRecord){
                    break;
                }
            }

            if($hasDependentRecord){
               return 'dependent';
            } else {
                return $model::destroy($records) ? 'success' : 'failure';
            }
        }
    }

    public static function softDeleteModelWithRelation($selectedRecords, $model)
    {
        if (!empty($selectedRecords)) {
            return $model::destroy($selectedRecords);
        }
    }

    public static function restoreModel($selectedRecords, $model)
    {
        if (is_array($selectedRecords)) {
            foreach ($selectedRecords as $id) {
                self::restoreRecord($id, $model);
            }
        } else {
            if (!empty($selectedRecords)) {
                self::restoreRecord($selectedRecords, $model);
            }
        }
    }

    private static function restoreRecord($id, $model)
    {
        $restoreModel = $model::withTrashed()->findOrFail($id);
        return $restoreModel->restore();
    }
}
