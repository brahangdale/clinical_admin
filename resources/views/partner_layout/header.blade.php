<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Partner - My Clinics</title>


<!-- =========================================================
     GOOGLE FONTS
========================================================= -->

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect"
      href="https://fonts.gstatic.com"
      crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700&display=swap"
      rel="stylesheet">


<!-- =========================================================
     BOOTSTRAP
========================================================= -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet">


<!-- =========================================================
     FONT AWESOME
========================================================= -->

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


<style>

/* =========================================================
   ROOT
========================================================= */

:root{

    --partner-primary:#2563eb;
    --partner-primary-dark:#1d4ed8;

    --partner-primary-soft:#eff6ff;

    --partner-text:#172033;
    --partner-muted:#7b8494;

    --partner-border:#e7ebf1;

    --partner-bg:#f7f9fc;

    --partner-white:#ffffff;

    --partner-success:#16a34a;

    --partner-danger:#dc2626;

    --partner-warning:#d97706;

}


/* =========================================================
   GLOBAL
========================================================= */

*{
    box-sizing:border-box;
}

body{

    margin:0;

    background:var(--partner-bg);

    color:var(--partner-text);

    font-family:'Inter',sans-serif;

    font-size:13px;

}

button,
input,
select,
textarea{

    font-family:'Inter',sans-serif;

}


/* =========================================================
   PAGE
========================================================= */

.partner-page{

    min-height:100vh;

    width:100%;

}


/* =========================================================
   TOP BAR
========================================================= */

.partner-topbar{

    width:100%;

    min-height:68px;

    background:#fff;

    border-bottom:1px solid var(--partner-border);

    padding:0 28px;

    display:flex;

    align-items:center;

    justify-content:space-between;

    gap:20px;

}


/* TOPBAR LEFT */

.partner-topbar-left{

    display:flex;

    align-items:center;

    gap:11px;

    min-width:0;

}


.partner-topbar-icon{

    width:38px;

    height:38px;

    flex:0 0 38px;

    border-radius:9px;

    display:flex;

    align-items:center;

    justify-content:center;

    background:var(--partner-primary-soft);

    color:var(--partner-primary);

    font-size:14px;

}


.partner-topbar-title{

    min-width:0;

}


.partner-topbar-title h5{

    margin:0;

    font-family:'Poppins',sans-serif;

    font-size:14px;

    font-weight:600;

}


.partner-topbar-title span{

    display:block;

    margin-top:2px;

    color:var(--partner-muted);

    font-size:8px;

}


/* TOPBAR RIGHT */

.partner-topbar-right{

    display:flex;

    align-items:center;

    gap:14px;

}


/* PARTNER PROFILE */

.partner-profile{

    display:flex;

    align-items:center;

    gap:9px;

}


.partner-avatar{

    width:36px;

    height:36px;

    flex:0 0 36px;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

    background:var(--partner-primary);

    color:#fff;

    font-size:10px;

    font-weight:600;

}


.partner-profile-info{

    line-height:1.2;

}


.partner-profile-info strong{

    display:block;

    font-size:10px;

    font-weight:600;

}


.partner-profile-info span{

    display:block;

    margin-top:3px;

    color:var(--partner-muted);

    font-size:8px;

}


/* LOGOUT */

.partner-logout-btn{

    height:35px;

    padding:0 12px;

    border:1px solid #e4e8ee;

    border-radius:7px;

    background:#fff;

    color:#667080;

    display:flex;

    align-items:center;

    gap:6px;

    font-size:9px;

    font-weight:500;

    transition:.2s;

}


.partner-logout-btn:hover{

    border-color:#fecaca;

    background:#fff5f5;

    color:var(--partner-danger);

}


/* =========================================================
   MAIN CONTENT
========================================================= */

.partner-content{

    width:100%;

    padding:28px;

}


/* =========================================================
   PAGE HEADER
========================================================= */

.partner-page-header{

    display:flex;

    align-items:center;

    justify-content:space-between;

    gap:20px;

    margin-bottom:22px;

}


.partner-heading h2{

    margin:0;

    font-family:'Poppins',sans-serif;

    font-size:22px;

    font-weight:600;

    letter-spacing:-.3px;

}


.partner-heading p{

    margin:5px 0 0;

    color:var(--partner-muted);

    font-size:11px;

}


.partner-generate-btn{

    height:41px;

    padding:0 16px;

    border:0;

    border-radius:8px;

    background:var(--partner-primary);

    color:#fff;

    display:flex;

    align-items:center;

    justify-content:center;

    gap:7px;

    font-size:10px;

    font-weight:600;

    white-space:nowrap;

    transition:.2s;

}


.partner-generate-btn:hover{

    background:var(--partner-primary-dark);

    transform:translateY(-1px);

}


/* =========================================================
   SEARCH
========================================================= */

.partner-search-wrapper{

    position:relative;

    margin-bottom:20px;

}


.partner-search-wrapper i{

    position:absolute;

    left:14px;

    top:50%;

    transform:translateY(-50%);

    color:#9aa3b2;

    font-size:11px;

}


.partner-search{

    width:100%;

    height:42px;

    border:1px solid var(--partner-border);

    border-radius:8px;

    background:#fff;

    padding:0 13px 0 38px;

    outline:none;

    color:var(--partner-text);

    font-size:10px;

}


.partner-search::placeholder{

    color:#a4acb9;

}


.partner-search:focus{

    border-color:#93c5fd;

    box-shadow:0 0 0 3px rgba(37,99,235,.05);

}


/* =========================================================
   SECTION HEADER
========================================================= */

.partner-section-header{

    display:flex;

    align-items:center;

    justify-content:space-between;

    margin-bottom:12px;

}


.partner-section-header h6{

    margin:0;

    font-family:'Poppins',sans-serif;

    font-size:13px;

    font-weight:600;

}


.partner-section-header span{

    color:var(--partner-muted);

    font-size:9px;

}


/* =========================================================
   CLINIC CARD
========================================================= */

.partner-clinic-card{

    height:100%;

    background:#fff;

    border:1px solid var(--partner-border);

    border-radius:13px;

    padding:16px;

    transition:.2s;

}


.partner-clinic-card:hover{

    border-color:#d4dce8;

    box-shadow:0 8px 26px rgba(15,23,42,.05);

}


/* CLINIC TOP */

.partner-clinic-top{

    display:flex;

    align-items:flex-start;

    gap:10px;

}


.partner-clinic-icon{

    width:44px;

    height:44px;

    flex:0 0 44px;

    border-radius:9px;

    background:var(--partner-primary-soft);

    color:var(--partner-primary);

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:15px;

}


.partner-clinic-info{

    min-width:0;

    padding-top:1px;

}


.partner-clinic-info h6{

    margin:0 0 4px;

    font-family:'Poppins',sans-serif;

    font-size:12px;

    font-weight:600;

    white-space:nowrap;

    overflow:hidden;

    text-overflow:ellipsis;

}


.partner-clinic-location{

    color:var(--partner-muted);

    font-size:8px;

    white-space:nowrap;

    overflow:hidden;

    text-overflow:ellipsis;

}


.partner-clinic-location i{

    margin-right:3px;

    color:#9aa3b2;

}


.partner-status{

    margin-left:auto;

    padding:4px 7px;

    border-radius:20px;

    background:#ecfdf3;

    /* color:#15803d; */
    color: white;

    font-size:7px;

    font-weight:600;

}


/* =========================================================
   CLINIC STATS
========================================================= */

.partner-clinic-stats{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:7px;

    margin-top:15px;

}


.partner-mini-stat{

    padding:9px 4px;

    text-align:center;

    background:#f8fafc;

    border-radius:7px;

}


.partner-mini-stat strong{

    display:block;

    font-family:'Poppins',sans-serif;

    font-size:13px;

    font-weight:600;

    line-height:1.2;

}


.partner-mini-stat span{

    display:block;

    margin-top:3px;

    color:var(--partner-muted);

    font-size:7px;

}


/* =========================================================
   CLINIC REVENUE
========================================================= */

.partner-clinic-revenue{

    display:flex;

    justify-content:space-between;

    gap:10px;

    margin-top:13px;

    padding-top:12px;

    border-top:1px solid #edf0f4;

}


.partner-revenue-item span{

    display:block;

    color:var(--partner-muted);

    font-size:7px;

}


.partner-revenue-item strong{

    display:block;

    margin-top:3px;

    font-family:'Poppins',sans-serif;

    font-size:10px;

    font-weight:600;

}


.partner-revenue-item:last-child{

    text-align:right;

}


.partner-revenue-item:last-child strong{

    color:var(--partner-success);

}


/* =========================================================
   CLINIC BUTTONS
========================================================= */

.partner-clinic-actions{

    display:grid;

    grid-template-columns:1fr 1fr;

    gap:7px;

    margin-top:14px;

}


.partner-clinic-btn{

    height:35px;

    border-radius:7px;

    display:flex;

    align-items:center;

    justify-content:center;

    gap:5px;

    font-size:8px;

    font-weight:600;

    transition:.2s;

}


.partner-view-info-btn{

    border:1px solid #e1e6ed;

    background:#fff;

    color:#667080;

}


.partner-view-info-btn:hover{

    border-color:#cbd5e1;

    background:#f8fafc;

    color:var(--partner-text);

}


.partner-performance-btn{

    border:1px solid #dbe7fb;

    background:var(--partner-primary-soft);

    color:var(--partner-primary);

}


.partner-performance-btn:hover{

    border-color:var(--partner-primary);

    background:var(--partner-primary);

    color:#fff;

}


/* =========================================================
   PERFORMANCE PANEL
========================================================= */

.partner-performance{

    display:none;

    margin-top:24px;

    background:#fff;

    border:1px solid var(--partner-border);

    border-radius:14px;

    overflow:hidden;

}


.partner-performance.active{

    display:block;

}


/* PERFORMANCE HEADER */

.partner-performance-header{

    padding:17px 20px;

    border-bottom:1px solid #edf0f4;

    display:flex;

    align-items:center;

    justify-content:space-between;

    gap:15px;

}


.partner-performance-title{

    display:flex;

    align-items:center;

    gap:10px;

}


.partner-performance-icon{

    width:39px;

    height:39px;

    border-radius:8px;

    background:var(--partner-primary-soft);

    color:var(--partner-primary);

    display:flex;

    align-items:center;

    justify-content:center;

}


.partner-performance-title h6{

    margin:0;

    font-family:'Poppins',sans-serif;

    font-size:12px;

    font-weight:600;

}


.partner-performance-title small{

    display:block;

    margin-top:3px;

    color:var(--partner-muted);

    font-size:8px;

}


.partner-close-btn{

    width:30px;

    height:30px;

    border:1px solid var(--partner-border);

    border-radius:7px;

    background:#fff;

    color:#7d8796;

    display:flex;

    align-items:center;

    justify-content:center;

}


.partner-close-btn:hover{

    color:var(--partner-danger);

    background:#fff5f5;

}


/* =========================================================
   DATE FILTER
========================================================= */

.partner-date-filter{

    padding:15px 20px;

    background:#fafbfc;

    border-bottom:1px solid #edf0f4;

}


.partner-date-label{

    display:block;

    margin-bottom:5px;

    color:#667080;

    font-size:8px;

    font-weight:600;

}


.partner-date-input{

    width:100%;

    height:37px;

    border:1px solid #e0e5ec;

    border-radius:7px;

    background:#fff;

    padding:0 9px;

    font-size:9px;

    outline:none;

}


.partner-date-input:focus{

    border-color:#93c5fd;

}


.partner-apply-btn{

    width:100%;

    height:37px;

    border:0;

    border-radius:7px;

    background:var(--partner-primary);

    color:#fff;

    font-size:9px;

    font-weight:600;

}


/* =========================================================
   PERFORMANCE BODY
========================================================= */

.partner-performance-body{

    padding:20px;

}


/* =========================================================
   PERFORMANCE STAT
========================================================= */

.partner-performance-card{

    height:100%;

    padding:15px;

    border:1px solid #e9edf2;

    border-radius:10px;

    background:#fff;

}


.partner-performance-card-icon{

    width:33px;

    height:33px;

    border-radius:7px;

    background:#f1f5f9;

    color:var(--partner-primary);

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:11px;

}


.partner-performance-card h3{

    margin:12px 0 3px;

    font-family:'Poppins',sans-serif;

    font-size:20px;

    font-weight:600;

}


.partner-performance-card p{

    margin:0;

    color:var(--partner-muted);

    font-size:8px;

}


.partner-performance-card.revenue h3{

    color:var(--partner-success);

}


/* =========================================================
   REVENUE SUMMARY
========================================================= */

.partner-revenue-summary{

    margin-top:20px;

    padding:16px;

    border:1px solid #e9edf2;

    border-radius:10px;

    background:#fafbfc;

}


.partner-revenue-summary h6{

    margin:0 0 10px;

    font-family:'Poppins',sans-serif;

    font-size:11px;

    font-weight:600;

}


.partner-revenue-line{

    display:flex;

    align-items:center;

    justify-content:space-between;

    gap:15px;

    padding:10px 0;

    border-bottom:1px solid #e9edf2;

}


.partner-revenue-line:last-child{

    border-bottom:0;

    padding-bottom:2px;

}


.partner-revenue-line span{

    color:#667080;

    font-size:9px;

}


.partner-revenue-line strong{

    font-family:'Poppins',sans-serif;

    font-size:11px;

    font-weight:600;

}


.partner-revenue-line.partner-payment strong{

    color:var(--partner-success);

}


/* =========================================================
   CLINIC INFO MODAL
========================================================= */

.partner-info-modal .modal-content{

    border:0;

    border-radius:14px;

    overflow:hidden;

}


.partner-info-header{

    padding:18px 20px;

    border-bottom:1px solid #edf0f4;

    display:flex;

    align-items:center;

    justify-content:space-between;

}


.partner-info-heading{

    display:flex;

    align-items:center;

    gap:10px;

}


.partner-info-icon{

    width:40px;

    height:40px;

    border-radius:9px;

    background:var(--partner-primary-soft);

    color:var(--partner-primary);

    display:flex;

    align-items:center;

    justify-content:center;

}


.partner-info-heading h6{

    margin:0;

    font-family:'Poppins',sans-serif;

    font-size:13px;

    font-weight:600;

}


.partner-info-heading small{

    display:block;

    margin-top:2px;

    color:var(--partner-muted);

    font-size:8px;

}


.partner-info-body{

    padding:20px;

}


.partner-info-grid{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:10px;

}


.partner-info-item{

    padding:12px;

    border:1px solid #edf0f4;

    border-radius:9px;

    background:#fafbfc;

}


.partner-info-item.full{

    grid-column:1/-1;

}


.partner-info-item span{

    display:block;

    margin-bottom:4px;

    color:var(--partner-muted);

    font-size:7px;

    text-transform:uppercase;

    letter-spacing:.3px;

}


.partner-info-item strong{

    display:block;

    color:var(--partner-text);

    font-size:9px;

    font-weight:600;

    line-height:1.5;

}


.partner-info-footer{

    padding:12px 20px;

    border-top:1px solid #edf0f4;

    display:flex;

    justify-content:flex-end;

}


.partner-modal-close{

    height:34px;

    padding:0 14px;

    border:1px solid #e1e6ed;

    border-radius:7px;

    background:#fff;

    color:#667080;

    font-size:9px;

}


/* =========================================================
   ADD CLINIC MODAL
========================================================= */

.partner-add-modal .modal-content{

    border:0;

    border-radius:14px;

    overflow:hidden;

}


.partner-modal-header{

    padding:18px 20px;

    border-bottom:1px solid #edf0f4;

}


.partner-modal-title{

    font-family:'Poppins',sans-serif;

    font-size:14px;

    font-weight:600;

}


.partner-modal-subtitle{

    margin-top:3px;

    color:var(--partner-muted);

    font-size:8px;

}


.partner-modal-body{

    padding:20px;

}


.partner-form-label{

    display:block;

    margin-bottom:5px;

    color:#4b5563;

    font-size:8px;

    font-weight:600;

}


.partner-form-control,
.partner-form-select{

    width:100%;

    height:39px;

    border:1px solid #e0e5ec;

    border-radius:7px;

    padding:0 10px;

    background:#fff;

    color:#303949;

    font-size:9px;

    outline:none;

}


.partner-form-control:focus,
.partner-form-select:focus{

    border-color:#93c5fd;

}


.partner-modal-footer{

    padding:13px 20px;

    border-top:1px solid #edf0f4;

    display:flex;

    justify-content:flex-end;

    gap:8px;

}


.partner-cancel-btn{

    height:35px;

    padding:0 13px;

    border:1px solid #e0e5ec;

    border-radius:7px;

    background:#fff;

    color:#667080;

    font-size:9px;

}


.partner-create-btn{

    height:35px;

    padding:0 14px;

    border:0;

    border-radius:7px;

    background:var(--partner-primary);

    color:#fff;

    font-size:9px;

    font-weight:600;

}


/* =========================================================
   SEARCH EMPTY
========================================================= */

.partner-no-result{

    display:none;

    text-align:center;

    padding:45px 20px;

}


.partner-no-result i{

    color:#cbd5e1;

    font-size:30px;

}


.partner-no-result h6{

    margin:11px 0 4px;

    font-family:'Poppins',sans-serif;

    font-size:12px;

}


.partner-no-result p{

    margin:0;

    color:var(--partner-muted);

    font-size:9px;

}


/* =========================================================
   MOBILE
========================================================= */

@media(max-width:767px){

    .partner-topbar{

        min-height:62px;

        padding:0 14px;

    }


    .partner-topbar-icon{

        width:34px;

        height:34px;

        flex-basis:34px;

        font-size:12px;

    }


    .partner-topbar-title h5{

        font-size:12px;

    }


    .partner-profile-info{

        display:none;

    }


    .partner-logout-btn span{

        display:none;

    }


    .partner-logout-btn{

        width:34px;

        padding:0;

        justify-content:center;

    }


    .partner-content{

        padding:18px 14px 35px;

    }


    .partner-page-header{

        align-items:flex-start;

        flex-direction:column;

        gap:12px;

    }


    .partner-heading h2{

        font-size:19px;

    }


    .partner-heading p{

        font-size:10px;

    }


    .partner-generate-btn{

        width:100%;

    }


    .partner-performance-header{

        padding:15px;

    }


    .partner-date-filter{

        padding:14px;

    }


    .partner-performance-body{

        padding:14px;

    }


    .partner-info-grid{

        grid-template-columns:1fr;

    }


    .partner-info-item.full{

        grid-column:auto;

    }

}


@media(max-width:400px){

    .partner-topbar-title{

        display:none;

    }


    .partner-clinic-actions{

        grid-template-columns:1fr;

    }


    .partner-clinic-btn{

        height:37px;

    }

}





/* =========================================================
   FONT SIZE BOOST
   Paste this at the END of your CSS
========================================================= */

/* Main headings */
.partner-heading h2{
    font-size:24px;
}

.partner-heading p{
    font-size:13px;
}


/* Topbar */
.partner-topbar-title h5{
    font-size:15px;
}

.partner-topbar-title span{
    font-size:9px;
}

.partner-profile-info strong{
    font-size:11px;
}

.partner-profile-info span{
    font-size:9px;
}

.partner-logout-btn{
    font-size:10px;
}


/* Search */
.partner-search{
    font-size:12px;
}


/* Section */
.partner-section-header h6{
    font-size:14px;
}

.partner-section-header span{
    font-size:10px;
}


/* Clinic card */
.partner-clinic-info h6{
    font-size:13px;
}

.partner-clinic-location{
    font-size:10px;
}

.partner-status{
    font-size:8px;
}


/* Clinic statistics */
.partner-mini-stat strong{
    font-size:15px;
}

.partner-mini-stat span{
    font-size:8.5px;
}


/* Revenue */
.partner-revenue-item span{
    font-size:8.5px;
}

.partner-revenue-item strong{
    font-size:11px;
}


/* Buttons */
.partner-clinic-btn{
    font-size:9.5px;
}


/* Performance title */
.partner-performance-title h6{
    font-size:14px;
}

.partner-performance-title small{
    font-size:9px;
}


/* Date filter */
.partner-date-label{
    font-size:9px;
}

.partner-date-input{
    font-size:10px;
}

.partner-apply-btn{
    font-size:10px;
}


/* Performance cards */
.partner-performance-card h3{
    font-size:23px;
}

.partner-performance-card p{
    font-size:9px;
}


/* Revenue summary */
.partner-revenue-summary h6{
    font-size:12px;
}

.partner-revenue-line span{
    font-size:10px;
}

.partner-revenue-line strong{
    font-size:12px;
}


/* Clinic information modal */
.partner-info-heading h6{
    font-size:14px;
}

.partner-info-heading small{
    font-size:9px;
}

.partner-info-item span{
    font-size:8px;
}

.partner-info-item strong{
    font-size:10px;
}


/* Add clinic modal */
.partner-modal-title{
    font-size:15px;
}

.partner-modal-subtitle{
    font-size:9px;
}

.partner-form-label{
    font-size:9px;
}

.partner-form-control,
.partner-form-select{
    font-size:10px;
}

.partner-cancel-btn,
.partner-create-btn{
    font-size:10px;
}



@media(max-width:767px){

    .partner-heading h2{
        font-size:20px;
    }

    .partner-clinic-info h6{
        font-size:13px;
    }

    .partner-mini-stat strong{
        font-size:15px;
    }

    .partner-performance-card h3{
        font-size:21px;
    }

}

</style>

</head>


<body>


<div class="partner-page">
  <!-- =========================================================
     TOPBAR
  ========================================================= -->

  <header class="partner-topbar">
    <div class="partner-topbar-left">


        <div class="partner-topbar-icon">

            <i class="fa-solid fa-handshake"></i>

        </div>


        <div class="partner-topbar-title">

            <h5>
                Partner Portal
            </h5>

            <span>
                Clinic Partnership Management
            </span>

        </div>


    </div>



    <div class="partner-topbar-right">


        <div class="partner-profile">


            <div class="partner-avatar">
                {{session('name') }}
            </div>


            <div class="partner-profile-info">

                <strong>
                  {{ session('name')  }}
                </strong>

                <span>
                    Partner Admin
                </span>

            </div>


        </div>


        <button
            class="partner-logout-btn"
            onclick="partnerLogout()">

            <i class="fa-solid fa-right-from-bracket"></i>

            <span>
                Logout
            </span>

        </button>


    </div>

</header>