@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">System Check</h1>
            <p class="mt-1 text-sm text-gray-600">
                LibraryMS სისტემის სრული შემოწმება
                <span class="text-gray-400">•</span>
                <span class="text-blue-600">Created by Guram-jajanidze</span>
            </p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            <button id="runCheck" 
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 shadow-sm transition-all duration-200">
                <i class="fas fa-play mr-2"></i>
                შემოწმების გაშვება
            </button>
            
            <a href="{{ route('admin.system-check.download') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 shadow-sm transition-all duration-200">
                <i class="fas fa-download mr-2"></i>
                რეპორტის გადმოწერა
            </a>
        </div>
    </div>

    <!-- Check Results -->
    <div id="checkResults" class="hidden">
        <div class="bg-white shadow-lg rounded-xl border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                    <i class="fas fa-chart-bar mr-2 text-primary-500"></i>
                    შემოწმების შედეგები
                </h3>
            </div>
            
            <div class="p-6">
                <!-- Status Overview -->
                <div id="statusOverview" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <!-- Status cards will be populated by JavaScript -->
                </div>

                <!-- Detailed Results -->
                <div id="detailedResults">
                    <!-- Detailed results will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <!-- Loading State -->
    <div id="loadingState" class="hidden text-center py-12">
        <div class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-primary-600 bg-primary-50">
            <i class="fas fa-spinner fa-spin mr-3"></i>
            სისტემის შემოწმება მიმდინარეობს...
        </div>
    </div>

    <!-- Instructions -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <h4 class="text-sm font-medium text-blue-800">რა შემოწმდება?</h4>
                <div class="mt-2 text-sm text-blue-700">
                    <ul class="list-disc list-inside space-y-1">
                        <li>ფაილების სტრუქტურა და integrity</li>
                        <li>Database კავშირი და tables</li>
                        <li>Models, Controllers, Routes</li>
                        <li>Views და Templates</li>
                        <li>Security კონფიგურაცია</li>
                        <li>Performance settings</li>
                        <li>File permissions</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('runCheck').addEventListener('click', function() {
    const button = this;
    const loadingState = document.getElementById('loadingState');
    const checkResults = document.getElementById('checkResults');
    
    // Show loading state
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>მიმდინარეობს...';
    loadingState.classList.remove('hidden');
    checkResults.classList.add('hidden');
    
    // Make AJAX request
    fetch('{{ route("admin.system-check.run") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        displayResults(data);
        
        // Reset button
        button.disabled = false;
        button.innerHTML = '<i class="fas fa-play mr-2"></i>შემოწმების გაშვება';
        loadingState.classList.add('hidden');
        checkResults.classList.remove('hidden');
    })
    .catch(error => {
        console.error('Error:', error);
        alert('შეცდომა შემოწმების დროს');
        
        // Reset button
        button.disabled = false;
        button.innerHTML = '<i class="fas fa-play mr-2"></i>შემოწმების გაშვება';
        loadingState.classList.add('hidden');
    });
});

function displayResults(data) {
    // Status Overview
    const statusOverview = document.getElementById('statusOverview');
    statusOverview.innerHTML = `
        <div class="bg-${data.status === 'PASS' ? 'green' : 'red'}-50 border border-${data.status === 'PASS' ? 'green' : 'red'}-200 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-${data.status === 'PASS' ? 'green' : 'red'}-600">${data.status}</div>
            <div class="text-sm text-${data.status === 'PASS' ? 'green' : 'red'}-700">საერთო სტატუსი</div>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-red-600">${data.total_errors}</div>
            <div class="text-sm text-red-700">შეცდომები</div>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-yellow-600">${data.total_warnings}</div>
            <div class="text-sm text-yellow-700">გაფრთხილებები</div>
        </div>
    `;

    // Detailed Results
    const detailedResults = document.getElementById('detailedResults');
    let html = '';

    if (data.info && data.info.length > 0) {
        html += `
            <div class="mb-6">
                <h4 class="text-lg font-medium text-blue-900 mb-3">ℹ️ ინფორმაცია</h4>
                <div class="space-y-2">
                    ${data.info.map(info => `<div class="text-sm text-blue-700">${info}</div>`).join('')}
                </div>
            </div>
        `;
    }

    if (data.errors && data.errors.length > 0) {
        html += `
            <div class="mb-6">
                <h4 class="text-lg font-medium text-red-900 mb-3">🚨 შეცდომები</h4>
                <div class="space-y-2">
                    ${data.errors.map(error => `<div class="text-sm text-red-700 bg-red-50 p-2 rounded">${error}</div>`).join('')}
                </div>
            </div>
        `;
    }

    if (data.warnings && data.warnings.length > 0) {
        html += `
            <div class="mb-6">
                <h4 class="text-lg font-medium text-yellow-900 mb-3">⚠️ გაფრთხილებები</h4>
                <div class="space-y-2">
                    ${data.warnings.map(warning => `<div class="text-sm text-yellow-700 bg-yellow-50 p-2 rounded">${warning}</div>`).join('')}
                </div>
            </div>
        `;
    }

    if (data.total_errors === 0 && data.total_warnings === 0) {
        html = `
            <div class="text-center py-8">
                <i class="fas fa-check-circle text-green-500 text-4xl mb-4"></i>
                <h3 class="text-lg font-medium text-green-900 mb-2">🎉 ყველაფერი კარგადაა!</h3>
                <p class="text-green-700">LibraryMS სისტემა სრულყოფილად მუშაობს</p>
            </div>
        `;
    }

    detailedResults.innerHTML = html;
}
</script>
@endsection