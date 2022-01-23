<style>
    body,
    html {
        margin: 0;
        padding: 0;
    }

    .nav {
        position: sticky;
        background: #A8D8DF;
    }

    .nav-wrap {

        justify-content: space-between;
        align-items: center;
        top: 0;
        margin: 0 20vh;
        padding: 10px 0;
    }




    .icon {
        width: 50px;
        height: 50px;
        background-color: #CAE7E8;
    }

    .pages {
        border-left: white solid 1px;
        margin-left: 10px;
    }

    .wrap-art-search {
        margin-right: 60px;
    }

    /* PROFIL */
    .personal {
        margin-left: 10px;
        width: 50px;
        height: 50px;
    }

    .personal a {
        color: black;
        text-decoration: none;
    }

    .status {
        position: absolute;
        right: 0;
        top: 0;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: solid 2px #ffffff;
    }

    .status.user {
        background-color: #80d3ab;
    }

    /* SEARCH BAR */
    .search-bar {
        margin-right: 20px;

    }

    .search-bar form {
        margin: 0;
    }

    .search-bar .form-control {
        border: 1.5px solid #E3E6ED
    }

    .search-bar input.form-control:focus {
        box-shadow: none;
        border: 1.5px solid #E3E6ED;
        background-color: #F7F8FD;
        letter-spacing: 1px
    }

    .search-bar .btn-secondary {
        height: 100%;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .search-bar .btn-secondary:focus {
        box-shadow: none
    }

    /* MENU PAGES EFFECT */
    <?php require_once 'assets/css/menu-effect.php'; ?>
</style>