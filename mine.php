<?php
//构建二位数组
class Mine{
	public $area;
	public $c_row;
	public $c_col;
	public $rows;
	public $columns;
	public $grid=array();

	public function __construct($c_row,$c_col,$n=5,$rows=9,$columns=9){
		$this->c_row=$c_row;
		$this->c_col=$c_col;
		$this->rows=$rows;
		$this->columns=$columns;
		$this->area=$rows*$columns;
		for($i=0;$i<$n;$i++){
			$this->random();
		}
		if(count($this->grid)){
			$this->total();
		}
		return $this->grid;
	}
	public function random(){
		$key=rand(1,$this->area);
		$row=intval($key/$this->rows)?intval($key/$this->rows):1;
		$column=($key%$this->columns)?($key%$this->columns):$this->columns;
		if(in_array(array('row'=>$row,'column'=>$column,'value'=>"雷区"),$this->grid)){
			$this->random();
		}elseif($row==$this->c_row&&$column==$this->c_col){
			$this->random();
		}else{
			$this->grid[]=array('row'=>$row,'column'=>$column,'value'=>"雷区");
		}
	}
	public function total(){
		foreach($this->grid as $k => $v){
			foreach($this->around($v['row'],$v['column']) as $key => $val){
				if(in_array(array('row'=>$val['row'],'column'=>$val['column'],'value'=>'雷区'),$this->grid)){
					continue;
				}
				$num=0;
				foreach($this->around($val['row'],$val['column']) as $ikey =>$ival){
					if(in_array(array('row'=>$ival['row'],'column'=>$ival['column'],'value'=>'雷区'),$this->grid)){
						$num++;
					}
				}
				$this->grid[]=array('row'=>$val['row'],'column'=>$val['column'],'value'=>$num);
			}
		}
	}
	public function around($a,$b){
		$arr=array();
		for($i=$a-1;$i<=$a+1;$i++){//2,3,4
			for($j=$b-1;$j<=$b+1;$j++){//1,2,3
				if($i>0&&$j>0&&$i<=$this->rows&&$j<=$this->columns){
					$arr[]=array('row'=>$i,'column'=>$j,'value'=>'');
				}
			}
		}
		$key=array_search(array('row'=>$a,'column'=>$b,'value'=>''),$arr);
		if($key!==false){
			unset($arr[$key]);
		}
		return $arr;
	}
}
if(isset($_POST['x'])&&isset($_POST['y'])){
	$m=new Mine($_POST['x'],$_POST['y']);
	echo json_encode($m->grid);
}
?>
