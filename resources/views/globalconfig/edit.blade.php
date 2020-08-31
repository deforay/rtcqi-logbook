<!-- 
    Author             : Sudarmathi M
    Date               : 31 Aug 2020
    Description        : global config edit screen
    Last Modified Date : 31 Aug 2020
    Last Modified Name : Sudarmathi M
-->
@extends('layouts.main')
@php 
//dd($config);
@endphp
@section('content')

<div class="content-wrapper">
<div class="content-header row">
	<div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
		<h3 class="content-header-title mb-0 d-inline-block">Global Config</h3>
		<div class="row breadcrumbs-top d-inline-block">
		<div class="breadcrumb-wrapper col-12">
			<ol class="breadcrumb">
			<li class="breadcrumb-item">Manage
			</li>
			<li class="breadcrumb-item"><a href="/globalconfig/">Global Config</a>
			</li>
			<li class="breadcrumb-item active">Edit</li>
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
						<!-- <h4 class="form-section"><i class="la la-plus-square"></i> Edit Global Config</h4> -->
						<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
						<div class="heading-elements">
							<ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
								<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
							</ul>
						</div>
					</div>
					<div class="card-content collapse show">
						<div class="card-body">
						<div id="show_alert"  class="mt-1" style=""></div>
                    <form class="form form-horizontal" role="form" name="editglobalconfig" id="editglobalconfig" method="post" action="/globalconfig/edit" autocomplete="off" onsubmit="validateNow();return false;">
                    @csrf
                    
                    <div class="row">
                        @foreach($config as $key => $configs)
                        <div class="col-xl-6 col-lg-12">
                            <fieldset>
                                <h5>{{ $configs->display_name }}<span class="mandatory">*</span>
                                </h5>
                                <div class="form-group">
                                <input 
                                    type="text" 
                                    id="{{ $configs->global_name }}" 
                                    name="{{ $configs->global_name }}"
                                    title="Please Enter {{ $configs->display_name }}"
                                    value="{{ $configs->global_value }}" 
                                    class="form-control isRequired {{ $configs->is_numeric=='yes' ? 'isNumeric':'' }}" 
                                    autocomplete="off" 
                                    placeholder="Enter {{ $configs->display_name }}"
                                    @if($configs->is_numeric=='yes')
                                    onkeypress="return isNumberKey(event);"  
                                    @endif                                    
                                    >
                            </fieldset>
                        </div>
                       @endforeach
                    </div>
                    <div class="form-actions right">
                        <a href="/globalconfig" >
                        <button type="button" class="btn btn-warning mr-1">
                        <i class="ft-x"></i> Cancel
                        </button>
                        </a>
                        <button type="submit" onclick="validateNow();return false;" class="btn btn-primary">
                        <i class="la la-check-square-o"></i> Update
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
 duplicateName = true;
    function validateNow() {
        flag = deforayValidator.init({
            formId: 'editglobalconfig'
        });
        
        if (flag == true) {
            if (duplicateName) {
                document.getElementById('editglobalconfig').submit();
            }
        }
        else{
            // Swal.fire('Any fool can use a computer');
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display","block");
            $("html, body").animate({ scrollTop: "0" });
        }
    }

    function isNumberKey(evt) {
		var charCode = (evt.which) ? evt.which : evt.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;
		return true;
	}
</script>
@endsection