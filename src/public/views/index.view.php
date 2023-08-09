<h2>index</h2>
<main class='container'>
    <ul>
        <?php foreach ($products as $product): ?>
            <li>
                <?= $product['productName']?>
            </li>
        <?php endforeach; ?>
    </ul>
</main>    
