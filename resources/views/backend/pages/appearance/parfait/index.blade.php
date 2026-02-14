@extends('backend.layouts.master')

@section('title')
    {{ localize('Parfait Custom Options') }} {{ getSetting('title_separator') }} {{ getSetting('system_title') }}
@endsection

@section('contents')
    <section class="tt-section pt-4">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card tt-page-header">
                        <div class="card-body d-lg-flex align-items-center justify-content-lg-between">
                            <div class="tt-page-title">
                                <h2 class="h5 mb-0 tt-title">{{ localize('Parfait Ingredients') }}</h2>
                            </div>
                            <div class="tt-action">
                                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOptionModal">
                                    <i data-feather="plus"></i> {{ localize('Add Notification') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4 g-4">
                <!-- Bases -->
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                             <h5 class="mb-0 text-white">{{ localize('Base Layers') }}</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover tt-footable text-left" data-align="left" data-show-toggle="false">
                                <thead>
                                    <tr>
                                        <th>{{ localize('Name') }}</th>
                                        <th>{{ localize('Price') }}</th>
                                        <th>{{ localize('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bases as $base)
                                        <tr>
                                            <td>
                                                <span class="fw-bold">{{ $base->name }}</span>
                                                <br>
                                                <small class="text-muted">{{ $base->description }}</small>
                                            </td>
                                            <td>{{ formatPrice($base->price) }}</td>
                                            <td>
                                                <div class="dropdown tt-tb-dropdown">
                                                    <button type="button" class="btn p-0" data-bs-toggle="dropdown">
                                                        <i data-feather="more-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow">
                                                        <a class="dropdown-item" href="#" onclick="editOption({{ $base }})">
                                                            <i data-feather="edit-3" class="me-2"></i>{{ localize('Edit') }}
                                                        </a>
                                                        <a class="dropdown-item" href="{{ route('admin.appearance.parfait.delete', $base->id) }}" onclick="return confirm('{{ localize('Are you sure?') }}')">
                                                            <i data-feather="trash" class="me-2"></i>{{ localize('Delete') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Fruits -->
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                             <h5 class="mb-0 text-white">{{ localize('Fruits') }}</h5>
                        </div>
                        <div class="card-body">
                             <table class="table table-hover tt-footable text-left">
                                <thead>
                                    <tr>
                                        <th>{{ localize('Name') }}</th>
                                        <th>{{ localize('Price') }}</th>
                                        <th>{{ localize('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fruits as $fruit)
                                        <tr>
                                            <td><span class="fw-bold">{{ $fruit->name }}</span></td>
                                            <td>{{ formatPrice($fruit->price) }}</td>
                                            <td>
                                                <div class="dropdown tt-tb-dropdown">
                                                    <button type="button" class="btn p-0" data-bs-toggle="dropdown">
                                                        <i data-feather="more-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow">
                                                        <a class="dropdown-item" href="#" onclick="editOption({{ $fruit }})">
                                                            <i data-feather="edit-3" class="me-2"></i>{{ localize('Edit') }}
                                                        </a>
                                                        <a class="dropdown-item" href="{{ route('admin.appearance.parfait.delete', $fruit->id) }}" onclick="return confirm('{{ localize('Are you sure?') }}')">
                                                            <i data-feather="trash" class="me-2"></i>{{ localize('Delete') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                 <!-- Toppings -->
                 <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                             <h5 class="mb-0 text-white">{{ localize('Toppings (Crunch)') }}</h5>
                        </div>
                        <div class="card-body">
                             <table class="table table-hover tt-footable text-left">
                                <thead>
                                    <tr>
                                        <th>{{ localize('Name') }}</th>
                                        <th>{{ localize('Price') }}</th>
                                        <th>{{ localize('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($toppings as $topping)
                                        <tr>
                                            <td><span class="fw-bold">{{ $topping->name }}</span></td>
                                            <td>{{ formatPrice($topping->price) }}</td>
                                            <td>
                                                <div class="dropdown tt-tb-dropdown">
                                                    <button type="button" class="btn p-0" data-bs-toggle="dropdown">
                                                        <i data-feather="more-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow">
                                                        <a class="dropdown-item" href="#" onclick="editOption({{ $topping }})">
                                                            <i data-feather="edit-3" class="me-2"></i>{{ localize('Edit') }}
                                                        </a>
                                                        <a class="dropdown-item" href="{{ route('admin.appearance.parfait.delete', $topping->id) }}" onclick="return confirm('{{ localize('Are you sure?') }}')">
                                                            <i data-feather="trash" class="me-2"></i>{{ localize('Delete') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Drizzles -->
                 <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header bg-warning text-dark">
                             <h5 class="mb-0">{{ localize('Drizzles') }}</h5>
                        </div>
                        <div class="card-body">
                             <table class="table table-hover tt-footable text-left">
                                <thead>
                                    <tr>
                                        <th>{{ localize('Name') }}</th>
                                        <th>{{ localize('Price') }}</th>
                                        <th>{{ localize('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($drizzles as $drizzle)
                                        <tr>
                                            <td><span class="fw-bold">{{ $drizzle->name }}</span></td>
                                            <td>{{ formatPrice($drizzle->price) }}</td>
                                            <td>
                                                <div class="dropdown tt-tb-dropdown">
                                                    <button type="button" class="btn p-0" data-bs-toggle="dropdown">
                                                        <i data-feather="more-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end shadow">
                                                        <a class="dropdown-item" href="#" onclick="editOption({{ $drizzle }})">
                                                            <i data-feather="edit-3" class="me-2"></i>{{ localize('Edit') }}
                                                        </a>
                                                        <a class="dropdown-item" href="{{ route('admin.appearance.parfait.delete', $drizzle->id) }}" onclick="return confirm('{{ localize('Are you sure?') }}')">
                                                            <i data-feather="trash" class="me-2"></i>{{ localize('Delete') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Add Option Modal -->
    <div class="modal fade" id="addOptionModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ localize('Add New Ingredient') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.appearance.parfait.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">{{ localize('Type') }}</label>
                            <select name="type" class="form-select" required>
                                <option value="base">{{ localize('Base Layer') }}</option>
                                <option value="fruit">{{ localize('Fruit') }}</option>
                                <option value="topping">{{ localize('Topping (Crunch)') }}</option>
                                <option value="drizzle">{{ localize('Drizzle') }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ localize('Name') }}</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Mango Chunks" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ localize('Price') }}</label>
                            <input type="number" step="0.01" name="price" class="form-control" placeholder="0.00">
                        </div>
                         <div class="mb-3">
                            <label class="form-label">{{ localize('Description') }} (Optional)</label>
                            <input type="text" name="description" class="form-control" placeholder="e.g. Fresh & Sweet">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ localize('Layer Image') }} (Transparent PNG recommended)</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                         <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActive" checked>
                            <label class="form-check-label" for="isActive">{{ localize('Active') }}</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ localize('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Edit Option Modal -->
    <div class="modal fade" id="editOptionModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ localize('Edit Ingredient') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.appearance.parfait.update') }}" method="POST" id="editForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="editId">
                    <div class="modal-body">
                         <div class="mb-3">
                            <label class="form-label">{{ localize('Name') }}</label>
                            <input type="text" name="name" id="editName" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ localize('Price') }}</label>
                            <input type="number" step="0.01" name="price" id="editPrice" class="form-control">
                        </div>
                         <div class="mb-3">
                            <label class="form-label">{{ localize('Description') }}</label>
                            <input type="text" name="description" id="editDescription" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ localize('Layer Image') }}</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">{{ localize('Leave empty to keep current image') }}</small>
                            <div id="editImagePreview" class="mt-2"></div>
                        </div>
                         <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="editActive">
                            <label class="form-check-label" for="editActive">{{ localize('Active') }}</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ localize('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function editOption(option) {
            $('#editId').val(option.id);
            $('#editName').val(option.name);
            $('#editPrice').val(option.price);
            $('#editDescription').val(option.description);
            
            if(option.is_active == 1) {
                $('#editActive').prop('checked', true);
            } else {
                $('#editActive').prop('checked', false);
            }

            // Image Preview
            $('#editImagePreview').html('');
            if(option.image) {
                $('#editImagePreview').html('<img src="{{ asset('storage') }}/' + option.image + '" class="img-fluid rounded" style="max-height: 100px;">');
            }
            
            var modal = new bootstrap.Modal(document.getElementById('editOptionModal'));
            modal.show();
        }
    </script>
    @endpush
@endsection
