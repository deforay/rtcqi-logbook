<!-- 
    Author : Sudarmathi M
    Date : 27 Jan 2020
    Desc : Main page to integrate all the pages
    Modified : Prasath M
    Modified Date : 17-Feb-2020
-->
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
    <head>
    @include('layoutsections.header')

    </head>
    <style>
    .mandatory{color: #f30f00;}
  
  /* .select2-selection__clear{display:none;}
  .firstcaps{text-transform:capitalize;}
  #show_alert{display:none;}
  .spanFont{font-size:16px;}
  .select2-container--default{width:100% !important;}

  table>thead {
        background-color: #c0c1c19e !important;
        color: #59595d;
    }
    tr:nth-child(even) {
background-color: #f2f3f5;
} */
    </style>
    <body class="horizontal-layout horizontal-menu horizontal-menu-padding 2-columns  " data-open="click" data-menu="horizontal-menu" data-col="2-columns">
    
    <!-- navbar starts-->

    @include('layoutsections.headernav')
      
    <!-- navbar ends-->

    <!-- Side starts-->

    @include('layoutsections.mainmenu')

    <!-- Side ends -->

    <div class="app-content container center-layout mt-2">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
        
                @section('content')

                @show
                
            </div>
        </div>
    </div>
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
    <!-- footer starts-->

    @include('layoutsections.footer')
      
    <!-- footer ends-->

    <!-- JavaScript files-->

    @include('layoutsections.scripts')

<!-- JavaScript files-->
<!-- <div class="modal fade" id="modal_ajax" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="max-width:1000px">
      <div class="modal-content" id="modal-content"></div>
  </div>
</div> -->
  </body>
</html>
<script>
//   $(document).ready(function() {
//     var path = '<?php echo Request::path();?>';
//     var splitUrl = path.split('/');
//     if(splitUrl[0]=="dashboard")
//     {
//       $("#dashboard").addClass('active');  
//     }
//     else if(splitUrl[0]=="roles" || splitUrl[0]=="customermoudetails" || splitUrl[0]=="agents" ||splitUrl[0]=="agentkeyperson" ||splitUrl[0]=="agentsuppliermap" ||splitUrl[0]=="suppliers" ||splitUrl[0]=="locations" ||splitUrl[0]=="plants" ||splitUrl[0]=="customergroup" ||splitUrl[0]=="customers" ||splitUrl[0]=="rsc" ||splitUrl[0]=="dopw" ||splitUrl[0]=="globalconfig" ||splitUrl[0]=="holidaymaster" ||splitUrl[0]=="endproduct" ||splitUrl[0]=="mailtemplate")
//     {
//       $("#manage").addClass('open');
//       $("#"+splitUrl[0]).addClass('active');
//     }
//     else if(splitUrl[0]=="orders" ||splitUrl[0]=="sales" ||splitUrl[0]=="sto_orders"||splitUrl[0]=="sto_sales"||splitUrl[0]=="customerindentorder")
//     {
//       $("#transactions").addClass('open');
//       $("#"+splitUrl[0]).addClass('active');
//     }
//     else if(splitUrl[0]=="sectors" ||splitUrl[0]=="products" ||splitUrl[0]=="grade_category" ||splitUrl[0]=="grades" ||splitUrl[0]=="grade_price")
//     {
//       $("#product").addClass('open');
//       $("#"+splitUrl[0]).addClass('active');
//     }
//     else if(splitUrl[0]=="mou")
//     {
//       $("#moudash").addClass('open');
//       $("#"+splitUrl[0]).addClass('active');
//     }
//     else if(splitUrl[0]=="qtydiscount")
//     {
//       $("#discount").addClass('open');
//       $("#"+splitUrl[0]).addClass('active');
//     }
//     else if(splitUrl[0]=="reports")
//     {
//       $("#report").addClass('open');
//       $("#"+splitUrl[1]).addClass('active');
//     }
//     else if(splitUrl[0]=="ioclpayment")
//     {
//       $("#ioclpaymentmanagement").addClass('open');
//       $("#"+splitUrl[0]).addClass('active');
//     }
    

//   });

  // $(function(){
  //   $(".isRequired").on("blur", function(){ 
  //     $(this).val(function(_, v){
  //     return v.replace(/(^\s*)|(\s*$)/gi, "");
  //     });  
  //   }); 
  // });

     
  function showAjaxModal(url)
  {
      // SHOWING AJAX PRELOADER IMAGE
      jQuery('#modal_ajax .modal-content').html('');

      // LOADING THE AJAX MODAL
      jQuery('#modal_ajax').modal('show', {backdrop: 'true'});
      $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
      // SHOW AJAX RESPONSE ON REQUEST SUCCESS
      $.ajax({
          url: url,
          method: 'post',
          success: function (response)
          {
            
            jQuery('#modal_ajax .modal-content').html(response);
            
          }
      });
  }

  function scrolltoptocontent()
  {
      $("html, body").animate({ scrollTop: 0 }, "slow");
    return false;

  }
  
 
  </script>