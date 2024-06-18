<!-- 
    Author             : Sakthi
    Date               : 28 Feb 2022
    Description        : Roles add screen
    Last Modified Date : 28 Feb 2022
    Last Modified Name : Sakthi
-->
@extends('layouts.main')

@section('content')
<div class="content-wrapper">
<div class="content-header row">
	<div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
		<h3 class="content-header-title mb-0 d-inline-block">{{ __('messages.roles') }}</h3>
		<div class="row breadcrumbs-top d-inline-block">
		<div class="breadcrumb-wrapper col-12">
			<ol class="breadcrumb">
			<li class="breadcrumb-item">{{ __('messages.manage') }}
			</li>
			<li class="breadcrumb-item"><a href="/roles/">{{ __('messages.roles') }}</a>
			</li>
			<li class="breadcrumb-item active">{{ __('messages.add') }}</li>
			</ol>
		</div>
		</div>
	</div>
</div>
      <div class="content-body">
	<!-- horizontal grid start -->
	<section class="horizontal-grid" id="horizontal-grid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h4 class="form-section"><i class="la la-plus-square"></i> {{ __('messages.add') }} {{ __('messages.roles') }}</h4>
						<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
						<div class="heading-elements">
							<ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
								<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
							</ul>
						</div>
					</div>
                    <div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-2" id="showAlertdiv" role="alert" style="display:none"><span id="showAlertIndex"></span>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					</div>
					<div class="card-content collapse show">
						<div class="card-body">
                       
						    <div id="show_alert"  class="mt-1" style=""></div>
                        
                            <form class="form form-horizontal" role="form" name="addroles" id="addroles" method="post" action="/roles/add" autocomplete="off" onsubmit="validateNow();return false;">
                            @csrf
                                <div class="row">
                                    <div class="col-xl-6 col-lg-12">
                                        <fieldset>
                                            <h5>{{ __('messages.role_name') }} <span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" id="roleName" onblur="duplicateValidation('roles','role_name', this.id, 'Entered role name is already exist.')" class="form-control isRequired" autocomplete="off" placeholder="Enter a role name" name="roleName" title="Please enter role name">
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-xl-6 col-lg-12">
                                        <fieldset>
                                            <h5>{{ __('messages.role_code') }} <span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" id="roleCode" onblur="duplicateValidation('roles','role_code', this.id, 'Entered role code is already exist.')" class="form-control isRequired" autocomplete="off" placeholder="Enter a role code" name="roleCode" title="Please enter role code">
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-6 col-lg-12">
                                        <fieldset>
                                            <h5>Description <span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                                <textarea id="Description" class="form-control isRequired" autocomplete="off" placeholder="Enter the description" name="Description" title="Please enter the description"></textarea>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-xl-6 col-lg-12">
                                        <fieldset>
                                            <h5>{{ __('messages.dashboard') }}status<span class="mandatory">*</span>
                                            </h5>
                                            <div class="form-group">
                                            <select class="form-control isRequired" autocomplete="off" style="width:100%;" id="rolesStatus" name="rolesStatus" title="Please select status">
                                                <option value="active" selected>Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="row">
                                    <b class="ml-2">Note: </b> <p class="form-control-static">Unless you choose "access" the people belonging to this role will not be able to access other rights like "add", "edit" etc.</p>
                                </div>
                                <div class="form-group row">
                                    
                                    <div class="custom-control custom-switch  custom-control-lg col-sm-12">
                                        
                                            <label class="label-control" for="markAllOption">Check all Allowed/Denied
                                            <input type="checkbox" id="markAllOption" class="switchBootstrap" name="checkUnCekAll"
                                                data-on-text="allowed"
                                                data-off-text="denied"
                                                data-label-text="All"
                                                data-off-color="warning"
                                                data-indeterminate="true"
                                                onchange="checkAll(this);" />
                                            </label>
                                        
                                        
                                    </div>
                                </div>
                                <div class ="row">
                                        <?php $counter = 0; ?>
                                        <?php foreach ($resourceResult as $value) { ?>
                                        
                                        <div class="col-md-4 col-xs-12 col-sm-12">
                                                <div class="card box-shadow-0 border-blue-grey">
                                                  <div class="card-header card-head-inverse bg-blue-grey " style="padding: 1rem 1.5rem;">
                                                    <h4 class="card-title text-white"><?php echo ucwords($value->display_name);?></h4>
                                                    <hr>
                                                    <!-- <input type='checkbox' 
                                                                    class='switchBootstrap <?php echo $value->display_name; ?>' 
                                                                    value='deny'
                                                                    id="<?php echo $value->display_name; ?>"
                                                                    data-on-text='allowed'
                                                                    data-off-text='denied'
                                                                    data-off-color='warning'
                                                                    data-indeterminate="true"
                                                                onchange='checkCard(this);'/> -->
                                                  </div>
                                                  <div class="card-content collapse show">
                                                    
                                                    <ul class="list-group list-group-flush">
                                                        <?php foreach ($value->privilege as $privileges) { ?>
                                                            <?php ++$counter; ?>
                                                            <li class="list-group-item">
                                                                <label for="cekAllPrivileges<?php echo $counter;?>"><?php echo ucwords($privileges->display_name);?></label>
                                                              <span class="float-right">
                                                                    <input type='checkbox' 
                                                                    class='switchBootstrap cekAllPrivileges <?php echo $value->display_name; ?>' 
                                                                    id="cekAllPrivileges<?php echo $counter;?>"
                                                                    value='deny'
                                                                    name="resource[<?php echo $value->resource_id;?>][<?php echo $privileges->privilege_name;?>]"
                                                                    data-on-text='allowed'
                                                                    data-off-text='denied'
                                                                    data-off-color='warning'
                                                                onchange='checkManual(this);'/>
                                                                
                                                              </span>
                                                              
                                                            </li>
                                                        <?php } ?>
                                                          </ul>
                                                  </div>
                                                </div>
                                              </div>

                                              <?php } ?>
                                              
                                    
                                </div>
                                <div class="form-actions right">
                                    <a href="/roles" >
                                    <button type="button" class="btn btn-warning mr-1">
                                    <i class="ft-x"></i> {{ __('messages.cancel') }}
                                    </button>
                                    </a>
                                    <button type="submit" onclick="validateNow();return false;" class="btn btn-primary">
                                    <i class="la la-check-square-o"></i> {{ __('messages.save') }}
                                    </button>
                                </div>
							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	
	<!-- horizontal grid end -->
</section>
</div>
</div>

<script>
function checkAll(obj){
    if ( $(obj).prop('checked') == true ) {
        $('input:checkbox').attr('checked','checked');
        $( '.cekAllPrivileges' ).val('allow');
        $( '.bootstrap-switch' ).removeClass('bootstrap-switch-off');
        $( '.bootstrap-switch' ).addClass('bootstrap-switch-on');
        $( '.bootstrap-switch-container' ).css('margin-left','0px');
    } else {
        $( '.bootstrap-switch' ).addClass('bootstrap-switch-off');
        $( '.bootstrap-switch' ).removeClass('bootstrap-switch-on');
        $( '.bootstrap-switch-container' ).css('margin-left','-75px');
        $('input:checkbox').removeAttr('checked');
        $( '.cekAllPrivileges' ).val('deny');
    }
}
function checkCard(obj)
{
    let id = obj.id;
    alert(id);
    if ( $(obj).prop('checked') == true ) {
        $('input:checkbox').attr('checked','checked');
        $( "."+id ).val('allow');
        // $( '.bootstrap-switch' ).removeClass('bootstrap-switch-off');
        // $( '.bootstrap-switch' ).addClass('bootstrap-switch-on');
        // $( '.bootstrap-switch-container' ).css('margin-left','0px');
    } else {
        // $( '.bootstrap-switch' ).addClass('bootstrap-switch-off');
        // $( '.bootstrap-switch' ).removeClass('bootstrap-switch-on');
        // $( '.bootstrap-switch-container' ).css('margin-left','-75px');
        $('input:checkbox').removeAttr('checked');
        $( "."+id  ).val('deny');
    }
}
function checkManual(obj){
    if ( $(obj).prop('checked') == true ) {
        $( obj ).val('allow');
    } else {
        $( obj ).val('deny');
    }
}
 duplicateName = true;
    function validateNow() {
        let role = 0;
        flag = deforayValidator.init({
            formId: 'addroles'
        });
        var n = $("input:checked").length;
        if(flag==true)
        {
            if(n == 0) {
                flag='<div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-2" role="alert" ><div class="text-center" style="font-size: 18px;"><b>Please give any one role permissions</b></div>';
                flag+='<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
                role = 1;
            } else {
                flag = true;
            }
        }
        if (flag == true) {
            if (duplicateName) {
                document.getElementById('addroles').submit();
            }
        }
        else{
            if(role==1)
                $("html, body").animate({ scrollTop: 0 }, "slow");
            else
    			$(".infocus").focus();
            $('#show_alert').html(flag).delay(3000).fadeOut();
			$('#show_alert').css("display","block");
        }
    }

    function duplicateValidation(tableName, fieldName, obj, msg)
    {
        // alert(fnct)
        checkValue = document.getElementById(obj).value;
        // alert(checkValue)
        if(checkValue!='')
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/duplicateValidation') }}",
                method: 'post',
                data: {
                    tableName: tableName, fieldName: fieldName, value: checkValue,
                },
                success: function(result){
                    console.log(result)
                    if (result > 0)
                    {
                        $("#showAlertIndex").text(msg);
                        $('#showAlertdiv').show();
                        duplicateName = false;
                        document.getElementById(obj).value = "";
                        $('#'+obj).focus();
                        $('#'+obj).css('background-color', 'rgb(255, 255, 153)')
                        $('#showAlertdiv').delay(3000).fadeOut();
                    }
                    else {
                        duplicateName = true;
                    }
                }
            });
        }
    }
</script>
@endsection