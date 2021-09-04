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
     * @return \Illuminate\Http\Response
    */
     public function getById(int $id); 

     /**
      * create
      * @param array $attrubute
      * @return void
      */
     public function create(array $attrubute); 

     /**
      * specified resource update
      *
      * @param int $id
      * @param array $attrubute
      *
      */
     public function update( int $id,array $attrubute);  
        
     /**
      * specified resource delete
      *
      * @param int $id
      * @return void
      */
     public function delete($id);
     
}