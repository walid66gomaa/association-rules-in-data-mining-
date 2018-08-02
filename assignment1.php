

<!DOCTYPE html>
<html>
<head>
<style type="text/css">
	
	         body {
  background: #EAEBEC;
   width: 80%;
             font-family: "Andale Mono",monospace;
             margin: 40px auto;
             font-size: 20px;
             border: 1px solid red;
              color: #fff;
             padding: 10px;
             
             border: solid 1px #3A4655;
  box-shadow: 0 8px 50px -7px black;
   background: #3A4655;
}

.div1 {
             width: 60%;
             font-family: "Andale Mono",monospace;
             margin: 40px auto;
             font-size: 20px;
             border: 1px solid red;
              color: #fff;
             padding: 10px;
             
             border: solid 1px #3A4655;
  box-shadow: 0 8px 50px -7px black;
   background: #3A4655;
         }
</style>
	<title></title>
</head>
<body>

</body>

</html>


<?php
  echo (" <class='div1' div>");
  

 $minsub=$_POST['minsu'];
 $minconfident=$_POST['mincon'];

 function ReadFile1($FileName)
		{

			$myfile = fopen($FileName, "r") or die("Unable to open file!");

			$i=0;$cat= array();
			while($x= fgets($myfile))
					 {
					 
					 $x=substr($x, 0, -2);

					  $cat[$i]=$x;
					 
					  $i++;

						}

			array_pop($cat);

				//read last line caz in last line fgets didnt read \n		

			$fp = fopen($FileName,"r");
			fseek($fp, -1, SEEK_END); 
			$pos = ftell($fp);
			$LastLine = "";
			// Loop backword util "\n" is found.
			while((($C = fgetc($fp)) != "\n") && ($pos > 0)) {
			    $LastLine = $C.$LastLine;
			    fseek($fp, $pos--);
			  }
			   $LastLine=substr($LastLine, 0, -1);
			  $cat[$i]=$LastLine;

			

			fclose($myfile);

			return $cat;
		}


///////////////////////////////////////////////////////////

		function SearchInFirstarr($arr,$value)
		{

			for ($i=0; $i <sizeof($arr) ; $i++) 

				{

					if(strcmp($arr[$i]->items, $value)==0)
					{
						return $i;
						break;
					}
				}
				return -1;
			
		}

		//////////////////////////////////////////////////////
		function InThirdarr($arr,$str)
		{
            
                     
       	      foreach ($arr as $line ) {
                               $pos=0;
                               $temp=$line->items;
       	      	              $bufer=explode(";", $str);
                             $pos++;
                           $flag1=substr_count($temp, $bufer[0]);
                           $flag2=substr_count($temp, $bufer[1]);
                           $flag3=substr_count($temp, $bufer[2]);

                           if($flag1 &&$flag2 && $flag3)
                           {
                           	return  $pos;
                           }
         	      }
       
                return -1;


		}
		function Insecondarr($arr,$str)
		{
             $pos=0;
                     
       	      foreach ($arr as $line ) {
                              
                               $temp=$line->items;
       	      	              $bufer=explode(";", $str);
                            
                           $flag1=substr_count($temp, $bufer[0]);
                           $flag2=substr_count($temp, $bufer[1]);
                           

                           if($flag1 &&$flag2 )
                           {
                           	return  $pos;
                           }
                            $pos++;
         	      }
       
                return -1;


		}

		////////////////////////////////////////////////////////////////////////

	$catogries=ReadFile1("categories.txt");
	

	require 'candidate.php';
    

	
      
       $firstarr=array();
       foreach ($catogries as $line ) {


       	 $bufer=explode(";", $line);

       	 

       	 /// buld one item set 
       	 for ($i=0; $i< sizeof($bufer); $i++) {
       	 	
		       	 	$found=SearchInFirstarr($firstarr,$bufer[$i]);

		       	 	

		       	 	 if($found>=0)
			       	 	 { 
			       	 	 	
			       	 	 	continue ;
			       	 	 }
		       	 	 else
			       	 	 {  
			       	 	 	
			       	 	 	$temp=new candidate();
			       	 	 	$temp->items=$bufer[$i];
			       	 	 	array_push($firstarr,$temp);
			       	 	 }
		       	 }
       	
       }

  foreach ($firstarr as $key ) {
  	 
  	  foreach ($catogries as $line ) {

       	 	 	 
       	 			$bufer1=explode(";", $line);
       	 			
       	 			if (in_array($key->items, $bufer1)) {

                 $key->count++;
       	 	      }
       	 		}
  }



          $size=sizeof($firstarr);

  for ($i=0; $i <$size; $i++) {
                  $temp1=$firstarr[$i];
                  
                  

      if ($temp1->count<$minsub) {
      	
      	unset($firstarr[$i]);
       	
    
       } 
  	
  }
 

  array_splice($firstarr, 0, 0);




//////////////////////////////////////////////////////////////////////find tow item set//////////////////////////////////////////////////////////////////


       	 	 $secondarr=array();

       	 for ($i=0; $i <sizeof($firstarr) ; $i++) {

       	 	    for ($j=$i+1; $j <sizeof($firstarr) ; $j++) 
       	 	    	{
       	 	           $candidate=new candidate();
       	 	           $candidate->items=$firstarr[$i]->items.";".$firstarr[$j]->items;
   						array_push($secondarr, $candidate);


       	 	    	}
       	 	    }

	
	
    

       for ($i=0; $i < sizeof($secondarr); $i++) {
                     $temp=$secondarr[$i];
                     $bufer=explode(";", $temp->items);
       	      foreach ($catogries as $line ) {
                    
                           $flag1=substr_count($line, $bufer[0]);
                           $flag2=substr_count($line, $bufer[1]);

                           if($flag1 &&$flag2)
                           {
                           	$secondarr[$i]->count++;
                           }
         	      }
       }
      

       $size=sizeof($secondarr);

  for ($i=0; $i <$size; $i++) {
                  $temp1=$secondarr[$i];
                  
                  

      if ($temp1->count<$minsub) {
      	
      	unset($secondarr[$i]);
       	
    
       } 
  	
  }

  array_splice($secondarr, 0, 0);
 


  /////////////////////////////////////////////////////////////////////



         	 $thirdarr=array();

       	 for ($i=0; $i <sizeof($secondarr) -1; $i++) {
                     


       	 	    for ($j=$i+1; $j <sizeof($secondarr) ; $j++) 
       	 	    	{
                         $bufer=explode(";", $secondarr[$j]->items);         
                        if(substr_count($secondarr[$i]->items,  $bufer[0])==0)
                        {
		       	 	           $varable1=$secondarr[$i]->items.";".$bufer[0];
		       	 	           if(InThirdarr($thirdarr,$varable1) <0)
				       	 	           {
				       	 	           	
				       	 	           	$item1=new candidate();
				       	 	           	$item1->items=$varable1;
				       	 	           	array_push($thirdarr, $item1);

		       	 	           }
       	 	           }
                          if(substr_count($secondarr[$i]->items,  $bufer[1])==0)
                        {
			       	 	               $varable2=$secondarr[$i]->items.";".$bufer[1];
				       	 	           if(InThirdarr($thirdarr,$varable2) <0)
				       	 	           {
				       	 	           		$item2=new candidate();
				       	 	           	$item2->items=$varable2;
				       	 	           	array_push($thirdarr, $item2);
				       	 	           }
	       	 	        }


       	 	    	}
       	 	    }



       	 	     for ($i=0; $i < sizeof($thirdarr); $i++) {
                     $temp=$thirdarr[$i];
                     $bufer=explode(";", $temp->items);
       	      foreach ($catogries as $line ) {
                    
                           $flag1=substr_count($line, $bufer[0]);
                           $flag2=substr_count($line, $bufer[1]);
                           $flag3=substr_count($line, $bufer[2]);

                           if($flag1 &&$flag2&&$flag3)
                           {
                           
                           	$thirdarr[$i]->count++;
                           }
         	      }
       }



       /////delet < min subort

        $size=sizeof($thirdarr);

  for ($i=0; $i <$size; $i++) {
                  $temp1=$thirdarr[$i];
                  
                  

      if ($temp1->count<$minsub) {
      	
      	unset($thirdarr[$i]);
       	
    
       } 
  	
  }

  array_splice($thirdarr, 0, 0);


      $assosition=array();

      for ($i=0; $i <sizeof($thirdarr) ; $i++) { 
      	$buffer=explode(";", $thirdarr[$i]->items);
      	$count=$thirdarr[$i]->count;

      	$confident=$thirdarr[$i]->count/($secondarr[Insecondarr($secondarr,$buffer[0].";".$buffer[1])]->count);
      	$condition="";
      	if($confident>=$minconfident)
      	{
          $condition="Strong";
      	}
      	else
      	{
          $condition="Week";
      	}
         echo $buffer[0]." ^ ".$buffer[1]."--> ".$buffer[2]. " -------------------------   Confidence = ".$confident ."-----------".$condition;
         echo "<br>";



           $confident=$thirdarr[$i]->count/($secondarr[Insecondarr($secondarr,$buffer[0].";".$buffer[2])]->count);
           if($confident>=$minconfident)
      	{
          $condition="Strong";
      	}
      	else
      	{
          $condition="Week";
      	}

         echo $buffer[0]." ^ ".$buffer[2]."--> ".$buffer[1]. " -------------------------   Confidence = ".$confident."-----------".$condition;
           echo "<br>";


           

          $confident=$thirdarr[$i]->count/($secondarr[Insecondarr($secondarr,$buffer[1].";".$buffer[2])]->count);
             if($confident>=$minconfident)
      	{
          $condition="Strong";
      	}
      	else
      	{
          $condition="Week";
      	}
         echo $buffer[1]." ^ ".$buffer[2]."--> ".$buffer[0]. " -------------------------   Confidence = ".$confident."-----------".$condition;
          echo "<br>"; 



      $confident=$thirdarr[$i]->count/($firstarr[SearchInFirstarr($firstarr,$buffer[0])]->count);
           if($confident>=$minconfident)
      	{
          $condition="Strong";
      	}
      	else
      	{
          $condition="Week";
      	}
         echo $buffer[0]."--> ".$buffer[1]." ^ ".$buffer[2]. " -------------------------    Confidence = " .$confident."-----------".$condition;
          echo "<br>"; 



          $confident=$thirdarr[$i]->count/($firstarr[SearchInFirstarr($firstarr,$buffer[1])]->count);
           if($confident>=$minconfident)
      	{
          $condition="Strong";
      	}
      	else
      	{
          $condition="Week";
      	}

          echo $buffer[1]."--> ".$buffer[0]." ^ ".$buffer[2]. " -------------------------    Confidence = ".$confident."-----------".$condition;
          echo "<br>"; 



          $confident=$thirdarr[$i]->count/($firstarr[SearchInFirstarr($firstarr,$buffer[2])]->count);
             if($confident>=$minconfident)
      	{
          $condition="Strong";
      	}
      	else
      	{
          $condition="Week";
      	}

          echo $buffer[2]."--> ".$buffer[1]." ^ ".$buffer[0]. " -------------------------    Confidence = ".$confident."-----------".$condition;
          echo "<br>"; 


          echo "----------------------------------------------------------------------------------------------------------------------------------------------------------- <br>";

         

      }



        
        

     echo"<pre>";
       	 print_r($thirdarr);

       	 echo "</pre>";     

echo("</div>")


///////////////////////////


?>
