/**
 * THE CREATIVE COLLECTION CO. — Blog CMS
 * script.js
 *
 * LARAVEL INTEGRATION NOTES:
 * ─────────────────────────────────────────────────────────────────────────────
 * All AJAX calls are structured to work with Laravel API routes out of the box.
 * Replace DUMMY_BLOGS / DUMMY_CATEGORIES with real API endpoints by:
 *   1. Setting USE_API = true
 *   2. Setting API_BASE to your Laravel base URL
 *
 * Expected Laravel endpoints:
 *   GET /api/blogs?search=&category_id=&days=&page=
 *   GET /api/categories
 *   GET /api/blogs/{id}
 *   GET /api/blogs/{id}/related
 * ─────────────────────────────────────────────────────────────────────────────
 */

/* ── Config ── */
const USE_API   = false;                 // ← set true when backend is ready
const API_BASE  = '/api';               // ← your Laravel API base URL
const PER_PAGE  = 6;

/* ── Unsplash image pool (blog-relevant, no celebrities/IP) ── */
const BLOG_IMAGES = [
  'https://images.unsplash.com/photo-1517697471339-4aa32003c11a?w=800&q=80',
  'https://images.unsplash.com/photo-1551650975-87deedd944c3?w=800&q=80',
  'https://images.unsplash.com/photo-1533750349088-cd871a92f312?w=800&q=80',
  'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&q=80',
  'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=800&q=80',
  'https://images.unsplash.com/photo-1432888498266-38ffec3eaf0a?w=800&q=80',
  'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=800&q=80',
  'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800&q=80',
  'https://images.unsplash.com/photo-1489875347897-49f64b51c1f8?w=800&q=80',
];

/* ────────────────────────────────────────────────
   DUMMY DATA  (replace with Laravel API responses)
──────────────────────────────────────────────── */
const DUMMY_CATEGORIES = [
  { id: 1, name: 'Content Creation' },
  { id: 2, name: 'Social Media Strategy' },
  { id: 3, name: 'Influencer Campaigns' },
  { id: 4, name: 'Brand Identity' },
  { id: 5, name: 'Digital Growth' },
];

const DUMMY_BLOGS = [
  {
    id: 1,
    title: 'The Atomic Growth Club',
    short_description: 'How micro-community tactics helped a wellness brand achieve 4x organic growth in under 90 days — without a single paid ad.',
    content: '',
    image: BLOG_IMAGES[0],
    category_id: 3,
    created_at: '2025-05-01',
  },
  {
    id: 2,
    title: 'Feathered Lane Studios',
    short_description: 'Building a cult following through intentional content — a social strategy case study in silence, precision, and radical brand restraint.',
    content: '',
    image: BLOG_IMAGES[1],
    category_id: 2,
    created_at: '2025-05-12',
  },
  {
    id: 3,
    title: 'The Lazy Cow Cocktails',
    short_description: 'Content creation for a small-batch cocktail brand: how warm, tactile photography and playful copy drove a 200% increase in website traffic.',
    content: '',
    image: BLOG_IMAGES[2],
    category_id: 1,
    created_at: '2025-05-22',
  },
  {
    id: 4,
    title: 'Why Consistency Beats Virality',
    short_description: 'The myth of the viral moment and why the brands that win long-term are the ones who show up day after day with disciplined, on-brand content.',
    content: '',
    image: BLOG_IMAGES[3],
    category_id: 2,
    created_at: '2025-04-18',
  },
  {
    id: 5,
    title: 'Rebranding from the Inside Out',
    short_description: 'True brand transformation starts with clarity of purpose — not a new logo. How we helped a legacy brand find its voice for a modern audience.',
    content: '',
    image: BLOG_IMAGES[4],
    category_id: 4,
    created_at: '2025-04-05',
  },
  {
    id: 6,
    title: 'Data-Led Creative: The New Standard',
    short_description: 'Marrying analytics with aesthetic instinct — how we use performance data to inform creative decisions without killing the magic.',
    content: '',
    image: BLOG_IMAGES[5],
    category_id: 5,
    created_at: '2025-03-29',
  },
  {
    id: 7,
    title: 'The Short-Form Video Playbook',
    short_description: 'Everything we\'ve learned from producing hundreds of Reels and TikToks for clients across beauty, food, and lifestyle verticals.',
    content: '',
    image: BLOG_IMAGES[6],
    category_id: 1,
    created_at: '2025-03-14',
  },
  {
    id: 8,
    title: 'Partnerships That Actually Convert',
    short_description: 'Not all influencer partnerships are equal. Here\'s our framework for identifying, vetting, and activating creators who drive real results.',
    content: '',
    image: BLOG_IMAGES[7],
    category_id: 3,
    created_at: '2025-02-28',
  },
  {
    id: 9,
    title: 'Building a Content Calendar That Works',
    short_description: 'A content calendar isn\'t a spreadsheet — it\'s a strategic document. Here\'s how we build ones that keep teams aligned and audiences engaged.',
    content: '',
    image: BLOG_IMAGES[8],
    category_id: 1,
    created_at: '2025-02-10',
  },
];

/* ────────────────────────────────────────────────
   STATE
──────────────────────────────────────────────── */
let currentPage    = 1;
let activeCategory = null;
let searchQuery    = '';
let dateRange      = '';
let allBlogs       = [];
let filteredBlogs  = [];

/* ────────────────────────────────────────────────
   HELPERS
──────────────────────────────────────────────── */
function getCategoryName(id) {
  const cat = DUMMY_CATEGORIES.find(c => c.id === id);
  return cat ? cat.name : 'Uncategorized';
}

function formatDate(dateStr) {
  const d = new Date(dateStr);
  return d.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
}

function daysAgo(dateStr) {
  const now  = new Date();
  const then = new Date(dateStr);
  return Math.floor((now - then) / (1000 * 60 * 60 * 24));
}

/* ────────────────────────────────────────────────
   CARD RENDERER
   Returns HTML string for one blog card.
   Laravel: replace image src with Storage::url($blog->image)
──────────────────────────────────────────────── */
function renderCard(blog) {
  const catName = getCategoryName(blog.category_id);
  return `
    <div class="col-md-6 col-lg-4">
      <a class="cc-blog-card d-block" href="blog-detail.html?id=${blog.id}">
        <div class="card-img-wrap">
          <img src="${blog.image}" alt="${blog.title}" loading="lazy"/>
          <div class="card-badge-wrap">
            <span class="cc-badge">${catName}</span>
          </div>
        </div>
        <div class="card-body-cc">
          <div class="card-meta">
            <span><i class="bi bi-calendar3"></i> ${formatDate(blog.created_at)}</span>
          </div>
          <h3 class="card-title-cc">${blog.title}</h3>
          <p class="card-desc">${blog.short_description}</p>
          <span class="card-read-more">Read More <i class="bi bi-arrow-right-long"></i></span>
        </div>
      </a>
    </div>`;
}

/* ────────────────────────────────────────────────
   POPULATE CATEGORIES
──────────────────────────────────────────────── */
function populateCategories(categories) {
  // Dropdown
  const $select = $('#categoryFilter');
  $select.find('option:not(:first)').remove();
  categories.forEach(cat => {
    $select.append(`<option value="${cat.id}">${cat.name}</option>`);
  });

  // Pills
  const $pills = $('#categoryPills');
  $pills.empty();
  $pills.append(`<button class="cc-pill active" data-cat="">All</button>`);
  categories.forEach(cat => {
    $pills.append(`<button class="cc-pill" data-cat="${cat.id}">${cat.name}</button>`);
  });

  // Sidebar categories (detail page)
  const $sidebar = $('#sidebarCategories');
  if ($sidebar.length) {
    $sidebar.empty();
    categories.forEach(cat => {
      $sidebar.append(`
        <li>
          <a href="index.html?category=${cat.id}">
            ${cat.name} <i class="bi bi-arrow-right"></i>
          </a>
        </li>`);
    });
  }
}

/* ────────────────────────────────────────────────
   FILTER LOGIC
──────────────────────────────────────────────── */
function applyFilters(blogs) {
  return blogs.filter(b => {
    const matchSearch   = !searchQuery   || b.title.toLowerCase().includes(searchQuery.toLowerCase()) || b.short_description.toLowerCase().includes(searchQuery.toLowerCase());
    const matchCategory = !activeCategory || b.category_id === parseInt(activeCategory);
    const matchDate     = !dateRange     || daysAgo(b.created_at) <= parseInt(dateRange);
    return matchSearch && matchCategory && matchDate;
  });
}

/* ────────────────────────────────────────────────
   RENDER BLOGS
──────────────────────────────────────────────── */
function renderBlogs(reset = true) {
  if (reset) {
    currentPage  = 1;
    filteredBlogs = applyFilters(allBlogs);
  }

  const $container  = $('#blogContainer');
  const $spinner    = $('#loadingSpinner');
  const $empty      = $('#emptyState');
  const $loadMore   = $('#loadMoreWrap');

  if (reset) $container.empty();

  if (filteredBlogs.length === 0) {
    $empty.removeClass('d-none');
    $loadMore.addClass('d-none');
    return;
  }

  $empty.addClass('d-none');

  const start = (currentPage - 1) * PER_PAGE;
  const end   = start + PER_PAGE;
  const page  = filteredBlogs.slice(start, end);

  page.forEach(blog => {
    $container.append(renderCard(blog));
  });

  // Show/hide load more
  if (end >= filteredBlogs.length) {
    $loadMore.addClass('d-none');
  } else {
    $loadMore.removeClass('d-none');
  }
}

/* ────────────────────────────────────────────────
   SIMULATE AJAX (swap with real $.ajax for Laravel)
──────────────────────────────────────────────── */
function fetchBlogs() {
  if (USE_API) {
    /*
     * REAL LARAVEL CALL (uncomment when backend is ready):
     *
     * return $.ajax({
     *   url: `${API_BASE}/blogs`,
     *   method: 'GET',
     *   data: {
     *     search:      searchQuery,
     *     category_id: activeCategory,
     *     days:        dateRange,
     *     page:        currentPage,
     *   },
     *   headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
     * });
     */
  }

  // Dummy: return a resolved promise
  return $.Deferred().resolve({ data: DUMMY_BLOGS }).promise();
}

function fetchCategories() {
  if (USE_API) {
    /*
     * REAL LARAVEL CALL:
     * return $.ajax({ url: `${API_BASE}/categories`, method: 'GET' });
     */
  }
  return $.Deferred().resolve(DUMMY_CATEGORIES).promise();
}

/* ────────────────────────────────────────────────
   INIT HOMEPAGE
──────────────────────────────────────────────── */
function initHomepage() {
  const $spinner  = $('#loadingSpinner');

  $spinner.removeClass('d-none');

  // Load categories
  fetchCategories().done(cats => {
    populateCategories(cats);
  });

  // Simulate async load
  setTimeout(() => {
    fetchBlogs().done(res => {
      allBlogs = res.data || res;
      $spinner.addClass('d-none');
      renderBlogs(true);
    });
  }, 600);

  /* ── Search ── */
  let searchTimer;
  $('#searchInput').on('input', function () {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => {
      searchQuery = $(this).val().trim();
      renderBlogs(true);
    }, 350);
  });

  $('#searchBtn').on('click', function () {
    searchQuery = $('#searchInput').val().trim();
    renderBlogs(true);
  });

  /* ── Category dropdown ── */
  $('#categoryFilter').on('change', function () {
    activeCategory = $(this).val();
    syncPills(activeCategory);
    renderBlogs(true);
  });

  /* ── Category pills ── */
  $(document).on('click', '.cc-pill', function () {
    activeCategory = $(this).data('cat');
    syncPills(activeCategory);
    $('#categoryFilter').val(activeCategory);
    renderBlogs(true);
  });

  /* ── Date filter ── */
  $('#dateFilter').on('change', function () {
    dateRange = $(this).val();
    renderBlogs(true);
  });

  /* ── Reset ── */
  $('#resetFilters, #emptyReset').on('click', resetAll);

  /* ── Load More ── */
  $('#loadMoreBtn').on('click', function () {
    currentPage++;
    renderBlogs(false);
    // Laravel: fetchBlogs() with currentPage, then append results
  });

  /* ── URL param: category ── */
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('category')) {
    activeCategory = urlParams.get('category');
    $('#categoryFilter').val(activeCategory);
    syncPills(activeCategory);
  }
}

function syncPills(value) {
  $('.cc-pill').removeClass('active');
  $(`.cc-pill[data-cat="${value}"]`).addClass('active');
}

function resetAll() {
  searchQuery    = '';
  activeCategory = null;
  dateRange      = '';
  $('#searchInput').val('');
  $('#categoryFilter').val('');
  $('#dateFilter').val('');
  syncPills('');
  renderBlogs(true);
}

/* ────────────────────────────────────────────────
   INIT DETAIL PAGE
──────────────────────────────────────────────── */
function initDetailPage() {
  const urlParams = new URLSearchParams(window.location.search);
  const blogId    = parseInt(urlParams.get('id')) || 1;

  /* ── Load blog data ── */
  // Laravel: $.ajax({ url: `${API_BASE}/blogs/${blogId}` })
  const blog = DUMMY_BLOGS.find(b => b.id === blogId) || DUMMY_BLOGS[0];
  const catName = getCategoryName(blog.category_id);

  // Update hero
  $('#detailHero').css(
    'background-image',
    `url('${blog.image}')`
  );
  $('#detailCategory').text(catName);
  $('#detailTitle').text(blog.title);
  $('#detailDate').text(formatDate(blog.created_at));

  /* ── Populate sidebar categories ── */
  fetchCategories().done(cats => {
    populateCategories(cats);

    // Related blogs in sidebar
    const related = DUMMY_BLOGS
      .filter(b => b.category_id === blog.category_id && b.id !== blog.id)
      .slice(0, 3);

    const $rel = $('#relatedBlogs');
    if (related.length) {
      related.forEach(rb => {
        $rel.append(`
          <div class="sidebar-card">
            <img class="sidebar-card-img" src="${rb.image}" alt="${rb.title}" loading="lazy"/>
            <p class="sidebar-card-cat">${getCategoryName(rb.category_id)}</p>
            <a class="sidebar-card-title d-block" href="blog-detail.html?id=${rb.id}">${rb.title}</a>
          </div>`);
      });
    } else {
      $rel.html('<p style="font-size:12px;color:var(--mid)">No related articles.</p>');
    }
  });

  /* ── More Articles section ── */
  const morePosts = DUMMY_BLOGS.filter(b => b.id !== blog.id).slice(0, 3);
  const $more = $('#moreBlogs');
  morePosts.forEach(b => $more.append(renderCard(b)));
}

/* ────────────────────────────────────────────────
   NAVBAR SCROLL BEHAVIOUR
──────────────────────────────────────────────── */
function initNavbar() {
  $(window).on('scroll', function () {
    if ($(this).scrollTop() > 40) {
      $('#mainNavbar').addClass('scrolled');
    } else {
      $('#mainNavbar').removeClass('scrolled');
    }
  });
}

/* ────────────────────────────────────────────────
   DOCUMENT READY
──────────────────────────────────────────────── */
$(function () {
  initNavbar();

  // Detect page
  const page = window.location.pathname;

  if (page.includes('blog-detail')) {
    initDetailPage();
  } else {
    initHomepage();
  }
});
