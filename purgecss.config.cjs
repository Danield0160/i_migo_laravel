module.exports = {
    content: ['./**/*.html'],
    css: ['./public/css/index.css'],
    output: './dist/',
    whitelist: ["navbar navbar-expand-lg navbar-light fixed-top py-3", "container px-4 px-lg-5", "navbar-brand", "navbar-toggler navbar-toggler-right", "navbar-toggler-icon", "navbar-nav ms-auto my-2 my-lg-0", "nav-item", "nav-link", "masthead", "row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center", "col-lg-8 align-self-end", "divider", "col-lg-8 align-self-baseline", "text-white-75 mb-5", "btn btn-primary btn-xl", "page-section bg-primary", "text-white mt-0", "divider divider-light", "text-white-75 mb-4", "btn btn-light btn-xl", "page-section", "text-center mt-0", "divider", "row gx-4 gx-lg-5", "col-lg-3 col-md-6 text-center", "mt-5", "mb-2", "bi-gem fs-1 text-primary", "h4 mb-2", "text-muted mb-0", "bi-laptop fs-1 text-primary", "bi bi-people-fill fs-1 text-primary", "bi-heart fs-1 text-primary", "page-section bg-dark text-white", "mb-4", "btn btn-light btn-xl", "bg-light py-5", "small text-center text-muted"],
    defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || []
  }