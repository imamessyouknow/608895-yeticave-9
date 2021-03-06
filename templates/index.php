<section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <?php foreach($categories as $val): ?>
            			<li class="promo__item promo__item--<?=htmlspecialchars($val['symbol_code']); ?>">
                			<a class="promo__link" href="pages/all-lots.html"><?=htmlspecialchars($val['name']); ?></a>
            			</li>
			<?php endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <?php foreach ($suply as $val): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?=$val['img']; ?>" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?=htmlspecialchars($val['cat_name']); ?></span>
                    <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$val['id'];?>"><?=htmlspecialchars($val['lot_name']); ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?=htmlspecialchars(format_sum($val['start_price'])); ?></span>
                        </div>
                        <div class='<?=$time_left_class?>'>
                            <?=$diff_format; ?>
                        </div>
                    </div>
                </div>
            </li>
			<?php endforeach; ?>
        </ul>
    </section>