<template>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="footer__content">
                        <a href="index.html" class="footer__logo">
                            <img src="img/logo.svg" alt="">
                        </a>

                        <span class="footer__copyright">© DROLCINEMA 2023</span>

                        <nav class="footer__nav">
                            <a href="/a-propos">A propos</a>
                            <a href="/contact">Contacts</a>
                            <a href="/politique-de-confidentialité">Politque de confidentialité</a>
                        </nav>

                        <button class="footer__back" type="button">
                            <i class="icon ion-ios-arrow-round-up"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<style>
.footer {
    background-color: #111;
    color: #fff;
    padding: 30px 0;
}

.footer__logo {
    display: inline-block;
    margin-bottom: 15px;
}

.footer__nav a {
    color: #fff;
    margin-right: 20px;
    text-decoration: none;
}

.footer__nav a:hover {
    text-decoration: underline;
}

.footer__back {
    background-color: transparent;
    border: none;
    color: #fff;
    cursor: pointer;
    font-size: 30px;
    position: absolute;
    right: 20px;
    bottom: 20px;
}

.footer__back:hover {
    color: #ccc;
}

.footer__content {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.footer__content .container {
    max-width: 1140px;
    margin: 0 auto;
    text-align: center;
}

.footer__content .row {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}
</style>
