<?php


/*
 *   ____  _            _      _       _     _
 *  |  _ \| |          | |    (_)     | |   | |
 *  | |_) | |_   _  ___| |     _  __ _| |__ | |_
 *  |  _ <| | | | |/ _ \ |    | |/ _` | '_ \| __|
 *  | |_) | | |_| |  __/ |____| | (_| | | | | |_
 *  |____/|_|\__,_|\___|______|_|\__, |_| |_|\__|
 *                                __/ |
 *                               |___/
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author BlueLightJapan Team
 * 
*/

$dir = "target/";

$writer = new ReWriter();
$writer->Start($dir);

echo "Finished scanning\n";
sleep(2);

class ReWriter{

	public function Start($path){
		echo "Start scanning\n";
		$this->ScanFolder($path);
	}

	public function isScanFile($file){
		if($file === "." or $file === "..") return false;
		return true;
	}

	public function ScanFolder($path){
		sleep(1);
		$files = scandir($path);
		echo "Scanning ".$path."\n";
		foreach($files as $file){
			//var_dump($files);
			if($this->isScanFile($path.$file."/")){
				if(is_dir($file)){
					$this->ScanFolder($path.$file."/");
				}else{
					$this->ReWrite($path.$file);
				}
			}
		}
	}

	public function ReWrite($file){
		sleep(1);
		chmod($file,0777);
		//$data = file_get_contents($file);
		$file_array = file($file);
		$data = "";
		foreach($file_array as $line){
			$data = $data.$line;
		}

		$before = 'pocketmine\network\protocol';
		$after  = 'pocketmine\network\mcpe\protocol';
		echo "Scanning ".$file."\n";
		if(strstr($data,$before)){
			$data2 = str_replace($before,$after,$data);
			file_put_contents($file,$data2);
			echo "Rewrite ".$file."\n";
			$this->ReWrite($file);
		}
	}
}
