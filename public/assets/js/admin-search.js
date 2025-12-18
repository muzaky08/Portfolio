const searchInput = document.querySelector('#adminSearchInput');
const searchPanel = document.querySelector('#adminSearchPanel');
const searchResults = document.querySelector('#adminSearchResults');
const searchHistoryBox = document.querySelector('#adminSearchHistory');

if (searchInput && searchPanel) {
    let debounceTimer;
    let abortController;

    const renderHistory = (history = []) => {
        if (!history.length) {
            searchHistoryBox.innerHTML = '<span class="text-muted small">Belum ada pencarian.</span>';
            return;
        }
        searchHistoryBox.innerHTML = history
            .map((item) => `<button type="button" class="dropdown-item text-start history-item">${item}</button>`)
            .join('');
        searchHistoryBox.querySelectorAll('.history-item').forEach((btn) => {
            btn.addEventListener('click', () => {
                searchInput.value = btn.textContent;
                triggerSearch();
            });
        });
    };

    const renderResults = ({ results = [], history = [] }) => {
        renderHistory(history);
        if (!results.length) {
            searchResults.innerHTML = '<div class="text-muted small px-3 py-2">Tidak ada hasil.</div>';
            return;
        }
        searchResults.innerHTML = results
            .map((result) => `
                <a class="dropdown-item" href="${result.url}">
                    <div class="small text-muted">${result.section}</div>
                    <div>${result.title}</div>
                    <div class="small text-muted">${result.snippet}</div>
                </a>`)
            .join('');
    };

    const performSearch = (query) => {
        if (abortController) {
            abortController.abort();
        }
        abortController = new AbortController();
        fetch(`${searchInput.dataset.searchUrl}?q=${encodeURIComponent(query)}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            signal: abortController.signal,
        })
            .then((response) => response.json())
            .then((data) => {
                renderResults(data);
                searchPanel.classList.add('show');
            })
            .catch(() => {});
    };

    const triggerSearch = () => {
        clearTimeout(debounceTimer);
        const query = searchInput.value.trim();
        debounceTimer = setTimeout(() => performSearch(query), 200);
    };

    searchInput.addEventListener('input', triggerSearch);
    searchInput.addEventListener('focus', () => {
        performSearch(searchInput.value.trim());
        searchPanel.classList.add('show');
    });

    document.addEventListener('click', (event) => {
        if (!searchPanel.contains(event.target) && event.target !== searchInput) {
            searchPanel.classList.remove('show');
        }
    });
}
