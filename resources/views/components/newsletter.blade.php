<div class="newsletter">
    <div class="newsletter__title">Подписка на рассылку</div>
    <div class="newsletter__description">Подпишитесь на нашу новостную рассылку, чтобы всегда быть в курсе последних новинок рекламно-сувенирной продукции.</div>
    <form id="newsletter__form" class="newsletter__form" action="/subscribe" method="POST">
        @csrf
        <input class="newsletter__input" name="email" type="email" value="" placeholder="Введите email" required />
        <button class="newsletter__submit" type="submit">Подписаться</button>
    </form>
</div>
