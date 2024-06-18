<!--
User
    Date               : 28 May 2021
    Description        : User add screen
    Last Modified Date : 28 May 2021

-->
@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-10 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block"></h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">{{ __('messages.manage') }}
                        </li>
                        <li class="breadcrumb-item"><a href="/testsite/">{{ __('messages.user') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('messages.bulk_upload') }}</li>
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
                            <h4 class="form-section"><i class="la la-plus-square"></i> {{ __('messages.bulk_upload_user') }}</h4>
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
                                <div id="show_alert" class="mt-1" style=""></div>
                                <form class="form form-horizontal" role="form" name="uploadUser" enctype="multipart/form-data" id="uploadUser" method="post" action="/user/bulk-upload" autocomplete="off" onsubmit="validateNow();return false;">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-4 col-md-12">
                                            <label>{{ __('messages.select_file_for_upload') }}</label> <span class="mandatory">*</span>
                                            <span class="text-muted">.xls, .xslx</span>
                                            <input class="form-control isRequired" accept=".xlsx, .xls" type="file" name="user_excel" title="Please Select File" />
                                        </div>
                                    </div>
                                    <div class="row pt-2">
                                        <div class="col-md-12">
                                            <table class="table table-bordered pt-2">
                                                <tr>
                                                    <td>{{ __('messages.first_name') }}</td>
                                                    <td>{{ __('messages.last_name') }}</td>
                                                    <td>{{ __('messages.mobile_number') }}</td>
                                                    <td>{{ __('messages.email') }}</td>
                                                    <td>{{ __('messages.role') }}</td>
                                                    <td>{{ __('messages.user_mapping') }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-actions right">
                                        <a href="/testsite">
                                            <button type="button" class="btn btn-warning mr-1">
                                                <i class="ft-x"></i> {{ __('messages.cancel') }}
                                            </button>
                                        </a>
                                        <button type="submit" onclick="validateNow();return false;" class="btn btn-primary">
                                            <i class="la la-check-square-o"></i> {{ __('messages.upload') }}
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
            formId: 'uploadUser'
        });
        
        if (flag == true) {
            if (duplicateName) {
                document.getElementById('uploadUser').submit();
            }
        } else {
            // Swal.fire('Any fool can use a computer');
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display", "block");
            $(".infocus").focus();
        }
    }
</script>
@endsection