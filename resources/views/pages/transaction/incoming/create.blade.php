@extends('layout.main')

@section('content')
<div class="create-letter-page">
    <!-- Enhanced Breadcrumb -->
    <div class="breadcrumb-section">
        <x-breadcrumb :values="[__('menu.transaction.menu'), __('menu.transaction.incoming_letter'), __('menu.general.create')]">
        </x-breadcrumb>
    </div>

    <!-- Form Container -->
    <div class="form-container">
        <div class="form-header">
            <h2 class="form-title">Buat Surat Masuk Baru</h2>
            <p class="form-subtitle">Lengkapi informasi surat masuk dengan detail yang akurat</p>
        </div>

        <form action="{{ route('transaction.incoming.store') }}" method="POST" enctype="multipart/form-data" class="letter-form">
            @csrf
            <input type="hidden" name="type" value="incoming">

            <!-- Form Sections -->
            <div class="form-section">
                <h4 class="section-title">Informasi Dasar</h4>
                <div class="form-grid">
                    <div class="form-group">
                        <x-input-form name="reference_number" :label="__('model.letter.reference_number')"/>
                    </div>
                    <div class="form-group">
                        <x-input-form name="from" :label="__('model.letter.from')"/>
                    </div>
                    <div class="form-group">
                        <x-input-form name="agenda_number" :label="__('model.letter.agenda_number')"/>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h4 class="section-title">Tanggal</h4>
                <div class="form-grid-2">
                    <div class="form-group">
                        <x-input-form name="letter_date" :label="__('model.letter.letter_date')" type="date"/>
                    </div>
                    <div class="form-group">
                        <x-input-form name="received_date" :label="__('model.letter.received_date')" type="date"/>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h4 class="section-title">Deskripsi</h4>
                <div class="form-group-full">
                    <x-input-textarea-form name="description" :label="__('model.letter.description')"/>
                </div>
            </div>

            <div class="form-section">
                <h4 class="section-title">Detail Tambahan</h4>
                <div class="form-grid">
                    <div class="form-group">
                        <div class="input-wrapper">
                            <label for="classification_code" class="form-label">{{ __('model.letter.classification_code') }}</label>
                            <select class="form-select enhanced-select" id="classification_code" name="classification_code">
                                @foreach($classifications as $classification)
                                    <option value="{{ $classification->code }}" @selected(old('classification_code') == $classification->code)>
                                        {{ $classification->type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <x-input-form name="note" :label="__('model.letter.note')"/>
                    </div>
                    <div class="form-group">
                        <div class="input-wrapper">
                            <label for="attachments" class="form-label">{{ __('model.letter.attachment') }}</label>
                            <div class="file-input-wrapper">
                                <input type="file" class="form-control file-input @error('attachments') is-invalid @enderror"
                                       id="attachments" name="attachments[]" multiple/>
                                <div class="file-input-overlay">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Pilih file atau drag & drop</span>
                                    <small>Mendukung multiple files</small>
                                </div>
                            </div>
                            <span class="error invalid-feedback">{{ $errors->first('attachments') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('transaction.incoming.index') }}" class="btn btn-secondary btn-enhanced">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
                <button class="btn btn-primary btn-enhanced" type="submit">
                    <i class="fas fa-save"></i>
                    {{ __('menu.general.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.create-letter-page {
    background: #ffffff;
    min-height: 100vh;
    padding-bottom: 2rem;
}

.breadcrumb-section {
    background: white;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    border-bottom: 1px solid #e5e7eb;
    margin-bottom: 2rem;
    padding: 1rem 0;
}

.form-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

.form-header {
    text-align: center;
    margin-bottom: 2.5rem;
}

.form-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.form-subtitle {
    color: #6b7280;
    font-size: 1rem;
    margin: 0;
}

.letter-form {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.form-section {
    padding: 2rem;
    border-bottom: 1px solid #f3f4f6;
}

.form-section:last-of-type {
    border-bottom: none;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e5e7eb;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.form-grid-2 {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.form-group, .form-group-full {
    margin-bottom: 0;
}

.input-wrapper {
    margin-bottom: 1rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

/* Enhanced Form Controls */
.input-wrapper .form-control,
.input-wrapper .form-select,
.enhanced-select {
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    transition: all 0.2s ease;
    background: #ffffff;
}

.input-wrapper .form-control:focus,
.input-wrapper .form-select:focus,
.enhanced-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    outline: none;
}

.input-wrapper .form-control:hover,
.input-wrapper .form-select:hover,
.enhanced-select:hover {
    border-color: #d1d5db;
}

/* File Input Enhancement */
.file-input-wrapper {
    position: relative;
    border: 2px dashed #d1d5db;
    border-radius: 8px;
    padding: 2rem;
    text-align: center;
    transition: all 0.2s ease;
    background: #fafafa;
}

.file-input-wrapper:hover {
    border-color: #3b82f6;
    background: #f8faff;
}

.file-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.file-input-overlay {
    pointer-events: none;
    color: #6b7280;
}

.file-input-overlay i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    display: block;
    color: #9ca3af;
}

.file-input-overlay span {
    display: block;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.file-input-overlay small {
    font-size: 0.75rem;
    color: #9ca3af;
}

/* Enhanced Buttons */
.form-actions {
    padding: 2rem;
    background: #f9fafb;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
}

.btn-enhanced {
    padding: 0.75rem 2rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.875rem;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
}

.btn-enhanced:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.btn-primary.btn-enhanced {
    background: #3b82f6;
    color: white;
}

.btn-primary.btn-enhanced:hover {
    background: #2563eb;
    color: white;
}

.btn-secondary.btn-enhanced {
    background: #6b7280;
    color: white;
}

.btn-secondary.btn-enhanced:hover {
    background: #4b5563;
    color: white;
}

/* Form Validation Styling */
.is-invalid {
    border-color: #ef4444 !important;
}

.invalid-feedback {
    color: #ef4444;
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .form-title {
        font-size: 1.5rem;
    }

    .form-section {
        padding: 1.5rem 1rem;
    }

    .form-grid,
    .form-grid-2 {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column;
        gap: 1rem;
    }

    .btn-enhanced {
        width: 100%;
        justify-content: center;
    }
}

/* Override component styles */
.input-wrapper .form-control,
.input-wrapper .form-select {
    margin-bottom: 0;
}

.input-wrapper .mb-3 {
    margin-bottom: 0 !important;
}

/* Textarea Enhancement */
.input-wrapper textarea.form-control {
    min-height: 120px;
    resize: vertical;
}

/* Select Enhancement */
.enhanced-select option {
    padding: 0.5rem;
}

/* Focus States */
.file-input:focus + .file-input-overlay {
    color: #3b82f6;
}

.file-input-wrapper:has(.file-input:focus) {
    border-color: #3b82f6;
    background: #f8faff;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // File input enhancement
    const fileInput = document.getElementById('attachments');
    const fileInputWrapper = fileInput.closest('.file-input-wrapper');
    const overlay = fileInputWrapper.querySelector('.file-input-overlay');

    fileInput.addEventListener('change', function() {
        const fileCount = this.files.length;
        if (fileCount > 0) {
            overlay.innerHTML = `
                <i class="fas fa-check-circle" style="color: #10b981;"></i>
                <span style="color: #10b981;">${fileCount} file(s) dipilih</span>
                <small>Klik untuk mengubah pilihan</small>
            `;
            fileInputWrapper.style.borderColor = '#10b981';
            fileInputWrapper.style.background = '#f0fdf4';
        }
    });

    // Form validation enhancement
    const form = document.querySelector('.letter-form');
    const inputs = form.querySelectorAll('input, select, textarea');

    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() !== '') {
                this.classList.add('has-value');
            } else {
                this.classList.remove('has-value');
            }
        });
    });
});
</script>
@endsection
