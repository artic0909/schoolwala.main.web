@extends('admin.layouts.app')

@section('title', 'Video Importer - Schoolwala')

@section('content')
<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary">Video Importer</h5>
            </div>
            
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <p>Upload a CSV file to import videos. The CSV must contain at least the following columns: <strong>chapter_name, video_title, video_type, video_link, video_description, duration, views</strong>.</p>
                <p class="text-muted mb-2"><small>Note: Video thumbnail and note link will remain empty (nullable) and can be updated later.</small></p>
                
                <a href="{{ asset('video_import_template.csv') }}" class="btn btn-sm btn-outline-info mb-4" download>
                    <i class="bx bx-download"></i> Download CSV Template
                </a>

                <form action="{{ route('admin.video-importer.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="class_id" class="form-label">Choose Class</label>
                            <select name="class_id" id="class_id" class="form-select class-select" required>
                                <option value="" selected disabled>Choose Class</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="subject_id" class="form-label">Choose Subject</label>
                            <select name="subject_id" id="subject_id" class="form-select subject-select" required>
                                <option value="" selected disabled>Choose Subject</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mt-3" id="csv_upload_section" style="display: none;">
                        <div class="col-md-12 mb-3">
                            <label for="csv_file" class="form-label">CSV Upload</label>
                            <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv, .txt" required>
                        </div>
                        
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Upload & Import</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        let subjectRoute = "{{ route('admin.get-subjects', ':classId') }}";
        
        $('#class_id').on('change', function () {
            let classId = $(this).val();
            let subjectSelect = $('#subject_id');
            let csvSection = $('#csv_upload_section');
            
            subjectSelect.html('<option value="" selected disabled>Choose Subject</option>');
            csvSection.hide();
            
            if (classId) {
                let url = subjectRoute.replace(':classId', classId);
                $.get(url, function (data) {
                    $.each(data, function (key, subject) {
                        subjectSelect.append('<option value="' + subject.id + '">' + subject.name + '</option>');
                    });
                });
            }
        });
        
        $('#subject_id').on('change', function () {
            if ($(this).val()) {
                $('#csv_upload_section').show();
            } else {
                $('#csv_upload_section').hide();
            }
        });
    });
</script>
@endsection
