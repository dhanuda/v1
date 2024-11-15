<?PHP

    include 'helper.php';
    $obj = new Manageaccess();

    if(isset($_POST['form-id']) && $_POST['form-id']=='123'):
      $obj->setPermissionData($_POST['selRole']);    
      header("Location:  index.php");
      exit;   
    endif; 

    $defaultColArr = $obj->defaultCols(); 
    $colspan = count($defaultColArr)+1;
    $pagesData = $obj->pagesList(0);
    $userGroupList = $obj->userGroupList();


  $getAccess =  $obj->getPageAccessByRole(5,1);
  var_dump($getAccess);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <style>
  td.childIndent {
      text-indent: 1.5em;
  }
  </style>
</head>
 
<body>
 
  <form method="post" action="" >
    <input type="hidden" name="form-id" value="123">
    <div class="container">
  <h2>UserGroup</h2>
  <p> :</p>       
  <div class="row">
    <div class="col-sm-3">
      <label> Select Role </label>
    </div>  
    <div class="col-sm-3">
        <select name="selRole" id="selRole" class="form-control required" required>
              <option value="">Please select</option>
            <?php foreach($userGroupList as $groupID=>$groupName): ?>
              <option value="<?=$groupID?>"><?=$groupName?></option>
            <?php endforeach; ?>
        </select>
    </div>  
  </div>    
  <div class="row">
    <div class="col-sm-12"> <hr>  
    </div>  
  </div>         
  <div class="row">
    <div class="col-sm-12">          
      <table class="table table-striped">
         
        <tbody>
          <tr>
            <th> </th> 
            <?php foreach($defaultColArr as $accessId=>$accessName):?>
                <?php $row1Class = ($accessId=='all')?'' :'all'; ?>
              <th> <label><input type="checkbox" id='<?=$accessId?>' data-value="<?=$accessId?>" class='all_top_rows <?=$row1Class?>'> <?=$accessName?></label></th>
            <?php endforeach;?>
          </tr>
          <?php 
              foreach($pagesData as $page_id=>$pageData): 
              ?>
                <tr>
                  <td><b><?=$pageData['name']?></b></td>

                  <?php foreach($defaultColArr as $accessId=>$accessName):?> 
                    <td> <label><input type="checkbox" id="<?=$accessId.$page_id?>" name="<?=$accessId.'_'.$page_id?>" data-value="<?=$accessId.$page_id?>" class="all <?=$accessId?> <?='all'.$page_id?> groupAccess" value="1"></label></td>
                  <?php endforeach;?>
                </tr>  
              <?php
                
                if(!empty($pageData['childs'])):      
                  foreach($pageData['childs'] as $page_idC => $pageDataC): 
                  ?>
                     <tr>
                        <td class="childIndent">  <?=$pageDataC['name'] ?> </td>

                        <?php foreach($defaultColArr as $accessId=>$accessName): 
                          if($accessId=='all'){
                            ?>
                            <td>   </td>
                            <?php
                          }
                          else{
                               ?>
                               <td>  <input type="checkbox" id="<?=$accessId.$page_idC?>" name="<?=$accessId.'_'.$page_idC ?>" data-value="<?=$accessId?>" class="all  <?='all'.$page_id?>  <?=$accessId.$page_id?>  <?=$accessId?>  " value="1"></td>
                            <?php
                          }
                        ?> 
                          
                        <?php endforeach; ?>
                      </tr>
            <?php
                  endforeach;
                endif;  
              endforeach;
          ?>
        </tbody>
      </table>
    </div>  
  </div>     
  
  <div class="row">       
    <div  class="col-sm-12 text-center">
        <input type="submit" name="cmd" value="Save" class="btn btn-info">
    </div>
  </div>
</div>
</form>
</body>
<script>
  $(document).ready(function() {
      //set initial state.
      $('#textbox1').val(this.checked);

  //-----------------------Top Row Start --------------------------------------//
      $('.all_top_rows').change(function() {
           dataVal = $(this).attr('data-value');
          console.log(dataVal);
          if(this.checked) { 

            $('.'+dataVal).prop('checked', true);
          }
          else{
            $('.'+dataVal).prop('checked', false);
          }    
      });
  
    //-----------------------Top Row End --------------------------------------//



  //-----------------------Group Row Start --------------------------------------//
      $('.groupAccess').change(function() {
          dataVal = $(this).attr('data-value'); 
          dataGroup = $(this).attr('data-group'); 
          console.log('.'+dataVal+'_'+dataGroup);
          if(this.checked) { 

            $('.'+dataVal ).prop('checked', true);
          }
          else{
            $('.'+dataVal).prop('checked', false);
          }    
      });
  
    //-----------------------Group Row End --------------------------------------//
  });

</script>
</body>
</html>