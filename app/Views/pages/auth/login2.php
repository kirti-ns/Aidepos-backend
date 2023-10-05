
<body class="page">
	<style type="text/css">
		@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap");
*,
*::before,
*::after {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  outline-offset: 4px;
}

:root {
  /* subtle color palette */
  --black-1a: hsla(0, 0%, 0%, 0.2);
  /* basic color palette */
  --black-1: hsl(0, 0%, 0%);
  --black-2: hsl(0, 0%, 20%);
  --black-3: hsl(0, 0%, 30%);
  --white-1: hsl(0, 0%, 100%);
  --white-2: hsl(0, 0%, 90%);
  --green-1: hsl(100, 50%, 50%);
  --green-2: hsl(100, 50%, 40%);
  --blue-1: hsl(200, 50%, 50%);
  /* brands color palette */
  --fb-cr: #1877f2;
  --tw-cr: #1da1f2;
  --google-cr: #dd4b39;
  /* fonts */
  --ft-fy-fallback-1: sans-serif;
  --ft-fy-1: "Poppins", var(--ft-fy-fallback-1);
  --ft-se-300: 0.9rem;
  --ft-se-400: 1rem;
  --ft-se-600: 1.4rem;
  /* spaces */
  --space-200: 1em;
  --space-400: 2em;
  /* z-index */
  --zx-neg-400: -400;
}

/* components */
.page {
  color: var(--black-1);
  padding: var(--space-400);
  display: grid;
  min-height: 100vh;
  grid-template-rows: 1fr;
  grid-template-areas: "main";
  background-color: var(--white-1);
  font-family: var(--ft-fy-1);
  font-size: var(--ft-se-400);
}
.page__main {
  display: grid;
  place-items: center;
  grid-area: main;
}
.page__form-double {
  width: calc(100% - var(--space-400));
  max-width: 700px;
}

.form-double {
  /* for all children */
  --gap: var(--space-200);
  --br-rs: 4px;
  /* universal */
  --px-2: 2px;
  /* __title */
  --__title_ft-se: var(--ft-se-600);
  --__title_mn-bk: 1.5em 0.3em;
  /* __social-media */
  --__social-media_pg: var(--space-200);
  --__social-media_fx-bs: 40%;
  --__social-media_gap: 0.5em;
  /* __social-link */
  --__social-link_cr: var(--black-1);
  --__social-link_bd-cr: var(--white-2);
  --__social-link_ft-se: var(--ft-se-300);
  --__social-link_gap: var(--__social-media_gap);
  --__social-link_le-ht: 1.3rem;
  --__social-link_pg: 0.8em;
  /* __input */
  --__input_bd-cr: var(--white-2);
  --__input_le-ht: var(--__social-link_le-ht);
  --__input_pg: var(--__social-link_pg);
  --__input_ft-se: var(--__social-link_ft-se);
  /* __manually */
  --__manually_pg: var(--__social-media_pg);
  --__manually_fx-bs: var(--__social-media_fx-bs);
  --__manually_gap: var(--__social-link_gap);
  /* __footer */
  --__footer_bd-cr: var(--white-2);
  /* __link */
  --__link_cr: var(--black-3);
  --__link_pg: 1em 2em;
  /* __word */
  --__word_bd-cr: var(--white-1);
  --__word_wh: 40px;
  gap: var(--gap);
  overflow: hidden;
  display: flex;
  border: var(--px-2) solid var(--black-1a);
  border-radius: 10px;
  flex-direction: column;
}
.form-double__header {
  display: flex;
  justify-content: center;
}
.form-double__title {
  margin-inline: var(--space-200);
  margin-block: var(--__title_mn-bk);
  font-size: var(--__title_ft-se);
}
.form-double__body {
  display: flex;
  justify-content: space-evenly;
}
.form-double__social-media {
  padding: var(--__social-media_pg);
  gap: var(--__social-media_gap);
  display: flex;
  flex-basis: var(--__social-media_fx-bs);
  flex-direction: column;
}
.form-double__social-link {
  color: var(--__social-link_cr);
  gap: var(--__social-link_gap);
  padding: var(--__social-link_pg);
  display: flex;
  opacity: 0.9;
  font-size: var(--__social-link_ft-se);
  line-height: var(--__social-link_le-ht);
  border: none;
  border-radius: var(--br-rs);
  background-color: var(--__social-link_bd-cr);
  align-items: center;
  text-decoration: none;
}
.form-double__social-link_fb {
  --__social-link_bd-cr: var(--fb-cr);
  --__social-link_cr: var(--white-1);
}
.form-double__social-link_tw {
  --__social-link_bd-cr: var(--tw-cr);
  --__social-link_cr: var(--white-1);
}
.form-double__social-link_google {
  --__social-link_bd-cr: var(--google-cr);
  --__social-link_cr: var(--white-1);
}
.form-double__social-link:hover {
  opacity: 1;
}
.form-double__manually {
  padding: var(--__manually_pg);
  gap: var(--__manually_gap);
  display: flex;
  flex-basis: var(--__manually_fx-bs);
  flex-direction: column;
}
.form-double__input {
  padding: var(--__input_pg);
  outline: none;
  font-size: var(--__input_ft-se);
  line-height: var(--__input_le-ht);
  border: none;
  border-radius: var(--br-rs);
  border-bottom: var(--px-2) solid var(--white-2);
  background-color: var(--__input_bd-cr);
}
.form-double__input:focus {
  --__input_bd-cr: var(--white-1);
}
.form-double__footer {
  display: flex;
  background-color: var(--__footer_bd-cr);
  justify-content: space-evenly;
}
.form-double__link {
  padding: var(--__link_pg);
  color: var(--__link_cr);
  outline: none;
  width: 100%;
  text-align: center;
  text-decoration: none;
}
.form-double__link:hover {
  --__link_cr: var(--black-1);
}
.form-double__link:focus {
  box-shadow: inset 0 0 4px 2px var(--blue-1);
}

.vl {
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
}
.vl__word {
  width: var(--__word_wh);
  display: flex;
  aspect-ratio: 1;
  justify-content: center;
  background-color: var(--__word_bd-cr);
  align-items: center;
  border: var(--px-2) solid var(--black-1a);
  border-radius: 50%;
}
.vl::before {
  z-index: var(--zx-neg-400);
  width: var(--px-2);
  position: absolute;
  content: "";
  height: 100%;
  background-color: var(--black-1a);
}

.primary-button {
  --cr: var(--white-1);
  --bd-cr: var(--black-1);
  color: var(--cr);
  padding: 0.5em 0.8em;
  cursor: pointer;
  border: none;
  border-radius: var(--br-rs, 4px);
  background-color: var(--bd-cr);
  font-size: var(--ft-se-400);
  font-family: var(--ft-fy-1);
  transition: background-color 150ms linear;
}
.primary-button:hover {
  --bd-cr: var(--black-2);
}
.primary-button_green {
  --bd-cr: var(--green-1);
}
.primary-button_green:hover {
  --bd-cr: var(--green-2);
}

@media (max-width: 650px) {
  :root {
    font-size: 0.95rem;
  }

  .form-double__title {
    text-align: center;
  }
  .form-double__body {
    flex-direction: column;
  }
  .form-double__vl::before {
    width: 100%;
    height: 2px;
  }
  .form-double__footer {
    flex-direction: column;
  }
  .form-double__link {
    margin-inline: auto;
  }
}
	</style>
  <main class="page__main">
    <form class="form-double page__form-double">
      <div class="form-double__header">
        <h1 class="form-double__title">Login with Social Media or Manually</h1>
      </div>
      <div class="form-double__body">
        <div class="form-double__social-media"><a class="form-double__social-link form-double__social-link_fb" href="#"><i class="fa-brands fa-facebook-f"></i>Login with Facebook</a><a class="form-double__social-link form-double__social-link_tw" href="#"><i class="fa-brands fa-twitter"></i>Login with Twitter</a><a class="form-double__social-link form-double__social-link_google" href="#"><i class="fa-brands fa-google"></i>Login with Google+</a></div>
        <div class="vl form-double__vl"><span class="vl__word">or</span></div>
        <div class="form-double__manually">
          <input class="form-double__input" type="text" placeholder="Username" name="uname" required="required"/>
          <input class="form-double__input" type="password" placeholder="Password" name="psw" required="required"/>
          <input class="primary-button primary-button_green" type="submit" value="Login"/>
        </div>
      </div>
      <div class="form-double__footer"><a class="form-double__link" href="#">Sign up</a><a class="form-double__link" href="#">Forgot password?</a></div>
    </form>
  </main>
</body>