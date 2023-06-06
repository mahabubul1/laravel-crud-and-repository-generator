<?php
namespace Mahabub\CrudGenerator\Contracts;

interface BaseRepository {
        
     /**
      * all  resource get
      * @return Collection
      */
     public function getAll();
     
     /**
     *  specified resource get .
     *
     * @param  int  $id
     * @return Response
    */
     public function getById(int $id); 

     /**
      * create
      * @param  $request
      * @return Response
      */
     public function create($request); 

     /**
      * specified resource update
      *
      * @param int $id
      * @param request 
      *
      */
     public function update( int $id= null, $request);  
        
     /**
      * specified resource delete
      *
      * @param int $id
      * @return void
      */
     public function delete($id);
     
}