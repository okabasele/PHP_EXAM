<style>
    /*
=====
DEPENDENCES
=====
*/
    .r-link {
        display: var(--rLinkDisplay, inline-flex) !important;
    }

    .r-link[href] {
        color: var(--rLinkColor) !important;
        text-decoration: var(--rLinkTextDecoration, none) !important;
    }

    .r-list {
        padding-left: var(--rListPaddingLeft, 0) !important;
        margin-top: var(--rListMarginTop, 0) !important;
        margin-bottom: var(--rListMarginBottom, 0) !important;
        list-style: var(--rListListStyle, none) !important;
    }

    /*
=====
CORE STYLES
=====
*/

    .menu {
        --rLinkColor: var(--menuLinkColor, currentColor);
    }

    .menu__link {
        display: var(--menuLinkDisplay, block);
    }

    /* 
focus state 
*/

    .menu__link:focus {
        outline: var(--menuLinkOutlineWidth, 2px) solid var(--menuLinkOutlineColor, currentColor);
        outline-offset: var(--menuLinkOutlineOffset);
    }

    /* 
fading siblings
*/

    .menu:hover .menu__link:not(:hover) {
        --rLinkColor: var(--menuLinkColorUnactive, rgba(22, 22, 22, .35));
    }

    /*
=====
PRESENTATION STYLES
=====
*/

    .menu__list {
        display: flex;
    }

    .menu__link {
        padding:2vh;
        font-weight: 700;
        text-transform: uppercase;
    }

    /* 
=====
TEXT UNDERLINED
=====
*/

    .text-underlined {
        position: relative;
        overflow: hidden;
        will-change: color;
        transition: color .25s ease-out;
    }

    .text-underlined::before,
    .text-underlined::after {
        content: "";
        width: 0;
        height: 3px;
        background-color: var(--textUnderlinedLineColor, currentColor);

        will-change: width;
        transition: width .1s ease-out;

        position: absolute;
        bottom: 0;
    }

    .text-underlined::before {
        left: 50%;
        transform: translateX(-50%);
    }

    .text-underlined::after {
        right: 50%;
        transform: translateX(50%);
    }

    .text-underlined:hover::before,
    .text-underlined:hover::after {
        width: 100%;
        transition-duration: .2s;
    }

    /*
=====
DEMO
=====
*/

    .page__menu:nth-child(n+2) {
        margin-top: 3rem;
    }

    .r-link {
        --uirLinkDisplay: var(--rLinkDisplay, inline-flex);
        --uirLinkTextColor: var(--rLinkTextColor);
        --uirLinkTextDecoration: var(--rLinkTextDecoration, none);

        display: var(--uirLinkDisplay) !important;
        color: var(--uirLinkTextColor) !important;
        text-decoration: var(--uirLinkTextDecoration) !important;
    }
</style>