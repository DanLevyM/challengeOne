<template>
	<div>
		<div class="cover">
			<picture class="mb-2 mb-md-3"><img alt="Logo" loading="lazy"
					src="https://www.pathe.fr/media/home/featuring/logo/60542/lg/1/tt-eol-02.png"></picture>

		</div>

		<div class="container-home">
			<TheCarousel />
		</div>

		<section class="section section--border">
			<div class="container-fluid">
				<div class="row justify-content-center d-flex">
					<div class="col-12 col-xl-10">
						<h2 class="section__title section__title--mb"><b>DrolCinema</b> – Le meilleur endroit pour les films
						</h2>

						<p class="section__text">Plongez dans une expérience cinématographique inoubliable avec notre offre
							spéciale ! Profitez de notre offre découverte pour bénéficier de 20% de réduction sur les
							séances et de 15% de réduction sur les collations. Vous avez également la possibilité de
							réserver jusqu'à une semaine avant la séance pour planifier votre sortie au cinéma à la
							perfection.

							Si vous cherchez une option plus flexible, optez pour notre offre Drol ! Avec des séances
							illimitées et une réduction de 15% sur les collations, vous pourrez profiter de nos films autant
							que vous le souhaitez. De plus, vous pouvez réserver jusqu'à une semaine avant la séance, pour
							une expérience sans stress.</p>

						<p class="section__text">Ne manquez pas ces offres spéciales ! Réservez dès maintenant pour profiter
							de notre offre découverte ou optez pour notre offre Drol pour une expérience cinématographique
							sans limites.</p>
					</div>
				</div>

				<div class="row justify-content-center d-flex">

					<div class="col-12 col-md-12 col-lg-4 order-md-1 order-lg-2">
						<div class="price">
							<div class="price__item price__item--first"><span>Offre Découverte</span> <span>7€ <sub>/
										mois</sub></span></div>
							<div class="price__item"><span><font-awesome-icon icon="fa-solid fa-check" /> 1 an</span></div>
							<div class="price__item"><span><font-awesome-icon icon="fa-solid fa-check" /> 20% de réduction
									sur les séances</span></div>
							<div class="price__item"><span><font-awesome-icon icon="fa-solid fa-check" /> 15% de réduction
									sur la nourriture</span></div>
							<div class="price__item price__item--none"><font-awesome-icon
									icon="fa-solid fa-check" /><span>Possibilité de réserver jusqu’à 1 semaine avant la
									séance</span>
							</div>
							<a href="#" class="price__btn">Choisir cette offre</a>
						</div>
					</div>

					<div class="col-12 col-md-6 col-lg-4 order-md-3">
						<div class="price price--premium">
							<div class="price__item price__item--first"><span>Offre Drol</span> <span>20€
									<sub>/mois</sub></span></div>
							<div class="price__item"><span><font-awesome-icon icon="fa-solid fa-check" /> 1 an</span></div>
							<div class="price__item"><span><font-awesome-icon icon="fa-solid fa-check" /> Séances
									illimités</span></div>
							<div class="price__item"><span><font-awesome-icon icon="fa-solid fa-check" /> 15% de réduction
									sur la nourriture</span></div>
							<div class="price__item"><span><font-awesome-icon icon="fa-solid fa-check" /> Possibilité de
									réserver jusqu’à 1 semaine avant la séance</span></div>
							<a href="#" class="price__btn">Choisir cette Offre</a>
						</div>
					</div>

				</div>
			</div>
		</section>
	</div>
</template>

<script setup>
	import TheCarousel from "../../components/TheCarousel.vue";
</script>

<style>
.cover {
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	background-image: url('../../../public/cover.avif');
	background-size: cover;
	background-position: center top;
	height: 600px;
	width: 100%;
	z-index: -1;
}

.cover picture {
	width: 30%;
	height: 30%;
	margin-top: 150px;
	margin-left: 20px;
}

.container-home {
	margin-top: 500px;
}

@media (min-width: 768px) {
	.row--grid {
		margin-left: -15px;
		margin-right: -15px;
	}
}

.row--grid,
.row--form {
	margin-left: -10px;
	margin-right: -10px;
}

.price {
	display: flex;
	flex-direction: column;
	justify-content: flex-start;
	align-items: flex-start;
	padding: 20px;
	background-color: #222028;
	border-radius: 6px;
	margin-top: 30px;
	position: relative;
}

.price__item {
	display: flex;
	flex-direction: row;
	justify-content: flex-start;
	align-items: center;
	width: 100%;
	font-size: 16px;
	color: #fff;
	margin-top: 15px;
	padding-top: 15px;
	border-top: 1px solid #1a191f;
	position: relative;
}

.price__item--first span:last-child {
	font-weight: 400;
	color: #f9ab00;
	display: block;
	font-size: 32px;
	line-height: 100%;
}

.price__item--first span:last-child sub {
	font-size: 14px;
	bottom: 1px;
	font-weight: 400;
}

.price__item--first {
	font-size: 24px;
	font-weight: 400;
	margin-top: 0;
	padding-top: 0;
	border: none;
	color: #fff;
	justify-content: space-between;
}

.price__item span {
	display: flex;
	flex-direction: row;
	justify-content: flex-start;
	align-items: center;
}

.price__item svg {
	margin-right: 10px;
	line-height: 100%;
	color: #29b474;
	margin-top: 2px;
}

.price__item--none i {
	color: #eb5757;
}

@media (min-width: 1200px) {
	.price__btn {
		margin-top: 30px;
	}
}

.price__btn {
	display: flex;
	flex-direction: row;
	justify-content: center;
	align-items: center;
	height: 46px;
	width: 100%;
	border-radius: 6px;
	background-color: transparent;
	font-size: 14px;
	color: #fff;
	text-transform: uppercase;
	border: 2px solid #f9ab00;
	margin-top: 20px;
}

.price--premium .price__item--first span:last-child {
	color: #29b474;
}

.price--premium:before {
	content: '';
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	height: 2px;
	display: block;
	background-color: #29b474;
	border-radius: 6px 6px 0 0;
}

.price--premium .price__btn {
	border-color: #29b474;
}

@media (min-width: 768px) {
	.section {
		padding: 70px 0;
	}
}

.section {
    padding: 50px 0;
    position: relative;
}

</style>
