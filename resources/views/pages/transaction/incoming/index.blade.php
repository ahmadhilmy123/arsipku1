@extends('layout.main')

@section('content')
<div class="incoming-letters-page">
    <!-- Enhanced Breadcrumb Section -->
    <div class="page-header">
        <div class="breadcrumb-section">
            <x-breadcrumb :values="[__('menu.transaction.menu'), __('menu.transaction.incoming_letter')]">
                <a href="{{ route('transaction.incoming.create') }}" class="btn btn-primary enhanced-btn">
                    <i class="fas fa-plus"></i>
                    {{ __('menu.general.create') }}
                </a>
            </x-breadcrumb>
        </div>
    </div>

    <!-- Page Title & Search -->
    <div class="page-content">
        <div class="content-header">
            <div class="title-section">
                <h1 class="page-title">{{ __('menu.transaction.incoming_letter') }}</h1>
                <p class="page-subtitle">Kelola dan pantau semua surat masuk dengan mudah</p>
            </div>

            <!-- Search Bar -->
            <div class="search-section">
                <form method="GET" class="search-form">
                    <div class="search-input-group">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text"
                               name="search"
                               value="{{ $search }}"
                               placeholder="Cari berdasarkan nomor surat, pengirim, atau perihal..."
                               class="search-input">
                        <button type="submit" class="search-btn">Cari</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Letters List -->
        @if($data->count() > 0)
            <div class="letters-container">
                @foreach($data as $letter)
                    <div class="letter-card-wrapper">
                        <x-letter-card :letter="$letter" />
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pagination-container">
                <div class="pagination-info">
                    <span>Menampilkan {{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }} dari {{ $data->total() }} surat</span>
                </div>
                <div class="pagination-wrapper">
                    {!! $data->appends(['search' => $search])->links() !!}
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-inbox fa-3x"></i>
                </div>
                <h3 class="empty-title">
                    {{ empty($search) ? 'Belum ada surat masuk' : 'Surat tidak ditemukan' }}
                </h3>
                <p class="empty-subtitle">
                    {{ empty($search) ? 'Mulai dengan membuat surat masuk pertama Anda' : 'Coba gunakan kata kunci yang berbeda' }}
                </p>
                @if(empty($search))
                    <a href="{{ route('transaction.incoming.create') }}" class="btn btn-primary enhanced-btn">
                        <i class="fas fa-plus"></i>
                        Buat Surat Masuk
                    </a>
                @else
                    <a href="{{ route('transaction.incoming.index') }}" class="btn btn-secondary enhanced-btn">
                        Lihat Semua Surat
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<style>
.incoming-letters-page {
    background: #ffffff;
    min-height: 100vh;
    padding-bottom: 2rem;
}

.page-header {
    background: white;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border-bottom: 1px solid #e9ecef;
    margin-bottom: 2rem;
}

.breadcrumb-section {
    padding: 1rem 0;
}

.enhanced-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
    text-transform: none;
}

.enhanced-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
}

.enhanced-btn i {
    margin-right: 0.5rem;
}

.page-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

.content-header {
    margin-bottom: 2rem;
}

.title-section {
    text-align: center;
    margin-bottom: 2rem;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 0.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.page-subtitle {
    font-size: 1.1rem;
    color: #718096;
    margin: 0;
}

.search-section {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
}

.search-form {
    max-width: 600px;
    margin: 0 auto;
}

.search-input-group {
    display: flex;
    align-items: center;
    background: #f8f9fa;
    border-radius: 10px;
    padding: 0.5rem;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.search-input-group:focus-within {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.search-icon {
    color: #adb5bd;
    margin: 0 0.75rem;
    font-size: 1.1rem;
}

.search-input {
    flex: 1;
    border: none;
    background: transparent;
    padding: 0.75rem 0;
    font-size: 1rem;
    outline: none;
}

.search-input::placeholder {
    color: #adb5bd;
}

.search-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.search-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.letters-container {
    display: grid;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.letter-card-wrapper {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    overflow: hidden;
}

.letter-card-wrapper:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.pagination-container {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.pagination-info {
    color: #718096;
    font-size: 0.9rem;
}

.pagination-wrapper .pagination {
    margin: 0;
}

.pagination-wrapper .page-link {
    border-radius: 8px;
    margin: 0 2px;
    border: 1px solid #e2e8f0;
    color: #4a5568;
    padding: 0.5rem 0.75rem;
    transition: all 0.3s ease;
}

.pagination-wrapper .page-link:hover {
    background: #667eea;
    border-color: #667eea;
    color: white;
    transform: translateY(-1px);
}

.pagination-wrapper .page-item.active .page-link {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
    color: white;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.empty-icon {
    color: #cbd5e0;
    margin-bottom: 1.5rem;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.empty-subtitle {
    color: #718096;
    margin-bottom: 2rem;
    font-size: 1.1rem;
}

/* Animation for cards */
.letter-card-wrapper {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.6s ease forwards;
}

.letter-card-wrapper:nth-child(1) { animation-delay: 0.1s; }
.letter-card-wrapper:nth-child(2) { animation-delay: 0.2s; }
.letter-card-wrapper:nth-child(3) { animation-delay: 0.3s; }
.letter-card-wrapper:nth-child(4) { animation-delay: 0.4s; }
.letter-card-wrapper:nth-child(5) { animation-delay: 0.5s; }

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }

    .pagination-container {
        flex-direction: column;
        text-align: center;
    }

    .search-input-group {
        flex-direction: column;
        gap: 0.5rem;
    }

    .search-btn {
        width: 100%;
    }
}

/* Override styling untuk x-letter-card component */
.letter-card-wrapper .card {
    border: none !important;
    border-radius: 12px !important;
    box-shadow: none !important;
    background: transparent !important;
}

.letter-card-wrapper .card-header {
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%) !important;
    border-bottom: 1px solid #e2e8f0 !important;
    border-radius: 12px 12px 0 0 !important;
    padding: 1.25rem 1.5rem !important;
}

.letter-card-wrapper .card-body {
    padding: 1.5rem !important;
    background: white !important;
}

.letter-card-wrapper .card-footer {
    background: #f8f9fa !important;
    border-top: 1px solid #e2e8f0 !important;
    border-radius: 0 0 12px 12px !important;
    padding: 1rem 1.5rem !important;
}

/* Style untuk badge/status dalam card */
.letter-card-wrapper .badge {
    border-radius: 6px !important;
    padding: 0.375rem 0.75rem !important;
    font-weight: 600 !important;
    font-size: 0.75rem !important;
}

.letter-card-wrapper .badge-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    border: none !important;
}

.letter-card-wrapper .badge-success {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%) !important;
    border: none !important;
}

.letter-card-wrapper .badge-warning {
    background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%) !important;
    border: none !important;
}

.letter-card-wrapper .badge-danger {
    background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%) !important;
    border: none !important;
}

/* Style untuk button dalam card */
.letter-card-wrapper .btn {
    border-radius: 6px !important;
    font-weight: 600 !important;
    padding: 0.5rem 1rem !important;
    transition: all 0.3s ease !important;
    text-transform: none !important;
}

.letter-card-wrapper .btn:hover {
    transform: translateY(-1px) !important;
}

.letter-card-wrapper .btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    border: none !important;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3) !important;
}

.letter-card-wrapper .btn-success {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%) !important;
    border: none !important;
    box-shadow: 0 2px 8px rgba(72, 187, 120, 0.3) !important;
}

.letter-card-wrapper .btn-warning {
    background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%) !important;
    border: none !important;
    box-shadow: 0 2px 8px rgba(237, 137, 54, 0.3) !important;
}

.letter-card-wrapper .btn-danger {
    background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%) !important;
    border: none !important;
    box-shadow: 0 2px 8px rgba(245, 101, 101, 0.3) !important;
}

/* Style untuk teks dalam card */
.letter-card-wrapper .card-title {
    color: #2d3748 !important;
    font-weight: 700 !important;
    font-size: 1.1rem !important;
    margin-bottom: 0.5rem !important;
}

.letter-card-wrapper .card-text {
    color: #4a5568 !important;
    line-height: 1.6 !important;
}

.letter-card-wrapper .text-muted {
    color: #718096 !important;
}

/* Style untuk list dalam card */
.letter-card-wrapper .list-group-item {
    border: none !important;
    padding: 0.5rem 0 !important;
    background: transparent !important;
}

.letter-card-wrapper .list-group-item:not(:last-child) {
    border-bottom: 1px solid #e2e8f0 !important;
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .incoming-letters-page {
        background: #ffffff;
    }

    .page-header, .search-section, .letter-card-wrapper, .pagination-container, .empty-state {
        background: #ffffff;
        color: #2d3748;
    }

    .letter-card-wrapper .card-header {
        background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%) !important;
    }

    .letter-card-wrapper .card-body {
        background: #ffffff !important;
    }

    .letter-card-wrapper .card-footer {
        background: #f8f9fa !important;
    }

    .letter-card-wrapper .card-title {
        color: #2d3748 !important;
    }

    .letter-card-wrapper .card-text {
        color: #4a5568 !important;
    }

    .page-title {
        color: #2d3748;
    }

    .search-input-group {
        background: #f8f9fa;
        border-color: #e9ecef;
    }
}
</style>
@endsection
