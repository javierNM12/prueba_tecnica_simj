@extends('layouts.master')
{{-- Customize layout sections --}}
@section('subtitle', 'Listado')
@section('content_header_title', 'Listado de usuarios')
@section('content_header_subtitle', '')
{{-- Content body: main page content --}}
@section('content_body')
    <div class="d-none p-3 error-delete-user">
        <x-adminlte-alert theme="danger" title="Danger">
            {{ __('Se ha producido un error al eliminar el usuario') }}
        </x-adminlte-alert>
    </div>
    <div class="d-flex flex-wrap justify-content-between my-2">
        <div class="col d-flex justify-content-end">
            <button type="button" class="add-user btn btn-primary">{{ __('Añadir usuario') }}</button>
        </div>
    </div>
    <table class="table table-striped table-sm data-table">
        <thead class="thead">
            <tr>
                <th class="hidden-sm hidden-xs hidden-md">{{ __('Nombre') }}</th>
                <th class="hidden-sm hidden-xs hidden-md">{{ __('Email') }}</th>
                <th class="hidden-sm hidden-xs hidden-md">{{ __('Administrador') }}</th>
                <th class="hidden-sm hidden-xs hidden-md">{{ __('Acciones') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr data-id="{{ $user->id }}">
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="hidden-xs" data-checked="{{ $user->admin }}">{{ $user->admin ? __('Sí') : __('No') }}</td>
                    <td>
                        <i class="edit text-warning fa fa-fw fa-edit" data-url="{{ URL::route('users.edit', ['id' => $user->id]) }}"></i>
                        <i class="delete text-danger fa fa-fw fa-trash" data-url="{{ URL::route('users.delete_user', ['id' => $user->id]) }}"></i>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="modal fade" id="modal-default" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="d-none p-3 error-create-user">
                    <x-adminlte-alert theme="danger" title="Danger">
                        {{ __('Se ha producido un error al crear el usuario') }}
                    </x-adminlte-alert>
                </div>
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Nuevo Usuario') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="key" value="">
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Nombre') }}</label>
                        <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp">
                        <div class="invalid-feedback empty">
                            {{ __('Este campo no puede estar vacío') }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                        <div class="invalid-feedback empty">
                            {{ __('Este campo no puede estar vacío') }}
                        </div>
                        <div class="invalid-feedback email-taken">
                            {{ __('El email está en uso') }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <div class="invalid-feedback empty">
                            {{ __('Este campo no puede estar vacío') }}
                        </div>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="admin" name="admin">
                        <label class="form-check-label" for="admin">{{ __('Administrador') }}</label>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cerrar') }}</button>
                    <button type="button" class="save-user btn btn-primary"
                    data-check-email="{{ URL::route('users.is_email_in_use') }}"
                    data-url-new="{{ URL::route('users.create_user') }}"
                    data-url-edit="{{ URL::route('users.edit_user') }}">
                        {{ __('Guardar') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop
{{-- Push extra CSS --}}
@push('css')
@endpush
{{-- Push extra scripts --}}
@push('js')
    <script>
        var usersManagement = function() {
            var resetValidation = function() {
                $('.form-control').each(function(element) {
                    $(this).siblings('.empty').hide();
                })
                $('#email').siblings('.email-taken').hide();
            }
            var validateNewUser = function(is_edit) {
                resetValidation();
                valid = true;
                if (
                    $('#name').val() == '' ||
                    $('#email').val() == '' ||
                    $('#password').val() == ''
                ) {
                    $('.form-control').each(function(element) {
                        $(this).val() == '' ? $(this).siblings('.empty').show() : $(this).siblings('.empty').hide();
                    })
                    valid = false;
                }

                var request = $.ajax({
                    type: 'post',
                    url: $('.save-user').data('check-email'),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')
                    },
                    data: {
                        'email': $('#email').val(),
                        'id': $('#key').val()
                    }
                });

                request.done(function(data) {
                    if (data) {
                        $('#email').siblings('.email-taken').show();
                        valid = false;
                    } else {
                        $('#email').siblings('.email-taken').hide();
                    }
                });
                return valid;
            };

            return {
                load: function() {
                    $('.delete').on('click', function() {
                        element = $(this).parent().parent();
                        var request = $.ajax({
                            type: 'post',
                            url: $(this).data('url'),
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')
                            }
                        });

                        request.done(function(data) {
                            data = $.parseJSON(data);
                            if (data) {
                                element.remove();
                                $('.error-delete-user').addClass('d-none');
                            } else {
                                $('.error-delete-user').removeClass('d-none');
                            }
                        });
                    })

                    $('.add-user').on('click', function() {
                        $('#key').val('');
                        $('#name').val('');
                        $('#email').val('');
                        $('#password').val('');
                        $('#admin').prop('checked', false);

                        $('.modal').modal('toggle');
                    })

                    $('.save-user').on('click', function() {
                        if (!validateNewUser()) {
                            return;
                        }
                        data = {
                            'id': $('#key').val(),
                            'name': $('#name').val(),
                            'email': $('#email').val(),
                            'password': $('#password').val(),
                            'admin': $('#admin').prop('checked'),
                        };

                        var request = $.ajax({
                            type: 'post',
                            url: $('#key').val() != '' ? $(this).data('url-edit') : $(this).data('url-new'),
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')
                            },
                            data: data
                        });

                        request.done(function(data) {
                            data = $.parseJSON(data);
                            data ? location.reload() : $('.error-create-user').removeClass('d-none');
                        });
                    })

                    $('.edit').on('click', function() {
                        element = $(this).parent().parent();

                        $('#key').val(element.data('id'));
                        $('#name').val(element.find('td:nth-child(1)').text());
                        $('#email').val(element.find('td:nth-child(2)').text());
                        $('#password').val('');
                        $('#admin').prop('checked', !!element.find('td:nth-child(3)').data('checked'));
                        
                        $('.modal').modal('toggle');
                    })
                }
            }
        }();
    </script>
@endpush