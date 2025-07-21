@extends('layouts.app')
@section('title','Category')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">category Management</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <!-- Add category Button -->
                            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addcategoryModal">
                                Add category
                            </button>

                            <!-- categories Table -->
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $index => $category)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->description }}</td>
                                        <td>
                                            <!-- Edit -->
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editcategoryModal{{ $category->id }}">Edit</button>

                                            <!-- Delete -->
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editcategoryModal{{ $category->id }}" tabindex="-1" aria-labelledby="editLabel{{ $category->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('categories.update', $category->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editLabel{{ $category->id }}">Edit category</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="editName{{ $category->id }}" class="form-label">Name</label>
                                                            <input type="text" id="editName{{ $category->id }}" name="name" class="form-control" value="{{ $category->name }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="editDesc{{ $category->id }}" class="form-label">Description</label>
                                                            <textarea id="editDesc{{ $category->id }}" name="description" class="form-control" rows="4">{{ $category->description }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button class="btn btn-primary" type="submit">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add Modal -->
<div class="modal fade" id="addcategoryModal" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLabel">Add category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="addName" class="form-label">Name</label>
                        <input type="text" id="addName" name="name" class="form-control" placeholder="category Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="addDesc" class="form-label">Description</label>
                        <textarea id="addDesc" name="description" class="form-control" rows="4" placeholder="Description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection