<?php


namespace App\Services;


use App\Models\Production;

class SearchProductionService
{

    public function make($query)
    {
        $productionQuery = [];
        if(isset($query->production)){
            $productionQuery = $query->production;
        }
        $production = Production::with([
            'collaboration.collaborationTask',
            'correspondence.correspondenceTask',
            'installation',
            'order']);
        $production->where($productionQuery);

        $production =  isset($query->collaboration)  &&  $production->whereHas('collaboration', function ($query) use ($query){
                $query->where($query->collaborationQuery);
            });


        // TODO: Combine collaboration and collaboration.collaborationTask queries

        if(isset($query->collaboration)){
            $collaborationQuery = $query->collaboration;
            $production = $production->whereHas('collaboration', function ($query) use ($collaborationQuery){
                $query->where($collaborationQuery);
            });
        }
        if(isset($query->collaboration_task)){
            $collaborationTaskQuery = $query->collaboration_task;
            $production = $production->whereHas('collaboration.collaborationTask', function ($query) use ($collaborationTaskQuery){
                $query->where($collaborationTaskQuery);
            });
        }
        if(isset($query->correspondence_task)){
            $correspondenceTaskQuery = $query->correspondence_task;
            $production = $production->whereHas('correspondence.correspondenceTask', function ($query) use ($correspondenceTaskQuery){
                $query->where($correspondenceTaskQuery);
            });
        }
        if(isset($query->installation)){
            $installationQuery = $query->installation;
            $production = $production->whereHas('installation', function ($query) use ($installationQuery){
                $query->where($installationQuery);
            });

        }
        if(isset($query->order)){
            $orderQuery = $query->order;
            $production = $production->whereHas('order', function ($query) use ($orderQuery){
                $query->where($orderQuery);
            });
        }
        return $production->paginate(1);

    }
}