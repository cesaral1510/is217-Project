<?php



class CsvSingleton{

	public static function getInstance(){
        static $finalArray = null;
        if (null === $finalArray) {
            $finalArray = new static();
            $file = fopen("a.csv","r");
			$headers = fgetcsv($file);

			while(!feof($file)){
				$data = fgetcsv($file);
				$ids[] = $data[0]; 
				$school_array[] = array_combine($headers, $data);
			}
			$finalArray = array_combine($ids, $school_array);
			fclose($file);
		}
		return $finalArray;


    }
    public static function getRealTitle(){
    	
        if (null === $finalArrayT) {
           

            $file = fopen("t.csv","r");

			while(!feof($file)){
				$data[] = fgets($file);
				
			}
			
			fclose($file);
		}
		return $data;
    }



}
class PrintSchools{

	public static function printSchool(){
		$arrayData = CsvSingleton::getInstance();
		foreach ($arrayData as $key => $value) 
			echo '<a href="?page='.$key.'">'.$value["INSTNM"].'</a><br>';
	}
}

class SchoolInfo{

	public function returnInfo(){
		$id = $_REQUEST['page'];
		return CsvSingleton::getInstance()[$id];
	}

}
class SchoolInfoFactory{
	
	public static function Create(){
		return new SchoolInfo();
	}

}
class Page{
	public function __construct(){
		
		
		$schoolInfo = SchoolInfoFactory::Create();
		$school_info_toPrint = $schoolInfo->returnInfo();
		$title = CsvSingleton::getRealTitle();
		
		$count = 0;
		echo "<table  border='1'style='width:75%'>";

		foreach ($school_info_toPrint as $key => $value) {
			echo "<tr><td>".$title[$count]."</td><td>".$value."</td></tr>";	
			$count++;

		}
		
		echo "</table>";
		
	}

}
class PageSchools{
	public function __construct(){
	PrintSchools::printSchool();
	
}

}
if(isset($_REQUEST['page']))
$obj = new Page();
else
$obj = new PageSchools();

?>