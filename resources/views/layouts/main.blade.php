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
    .white {
        color:white;
    }
    .mandatory{color: #f30f00;}

    .single:hover{
      background-color: rgba(255, 255, 255, 0.05);
    }
  
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

    <div class="app-content container center-layout mt-2" style="min-height: 600px;">
        <div class="content-overlay"></div>
        
                @section('content')

                @show
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
  $(document).ready(function() {
    var path = '<?php echo Request::path();?>';
    var splitUrl = path.split('/');
    if(splitUrl[0]=="dashboard")
    {
      $("#dashboard").addClass('active');  
    }
  });

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