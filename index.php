<?php
require_once 'config/db.php';
// <!-- هذه استعلام  لجلب كل البيانات -->

$stmt = $conn->query('SELECT * FROM news');
$news = $stmt->fetch_all(MYSQLI_ASSOC);


?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>جميع الأخبار</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
body { background-color: #f4f6f9; color: #222; }

.navbar { background-color: #1f3c5b; padding: 15px 30px; }
.navbar ul { list-style: none; display: flex; justify-content: center; gap: 15px; flex-wrap: wrap; }
.navbar ul li a { color: white; text-decoration: none; padding: 8px 14px; border-radius: 6px; }
.navbar ul li a:hover { background-color: rgba(255,255,255,0.15); }

.container { width: 90%; max-width: 1100px; margin: 40px auto; }
h1 { text-align: center; margin-bottom: 30px; color: #1f3c5b; }

.news-card { display: flex; gap: 20px; background-color: white; border: 1px solid #ddd; border-radius: 10px; padding: 15px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
.news-card img { width: 220px; height: 140px; object-fit: cover; border-radius: 8px; }
.news-content { flex: 1; }
.category { display: inline-block; background-color: #dbeafe; color: #1f3c5b; padding: 5px 10px; border-radius: 20px; font-size: 13px; margin-bottom: 10px; }
.news-content h2 { margin-bottom: 10px; color: #1f3c5b; font-size: 22px; }
.news-content p { line-height: 1.8; margin-bottom: 12px; }
.details-link { color: #1f3c5b; text-decoration: none; font-weight: bold; }
.details-link:hover { text-decoration: underline; }
.empty { text-align: center; color: #888; padding: 60px 0; font-size: 18px; }

@media (max-width: 768px) {
  .news-card { flex-direction: column; }
  .news-card img { width: 100%; height: 200px; }
}
</style>
</head>
<body>

<div class="navbar">
  <ul>
    <li><a href="add-news.php">إضافة خبر</a></li>
    <li><a href="index.php">عرض الأخبار</a></li>
  </ul>
</div>

<div class="container">
  <h1>جميع الأخبار</h1>
  <div>

  <?php if (empty($news)): ?>
    <p class="empty">لا توجد أخبار حتى الآن. <a href="add-news.php">أضف أول خبر</a></p>
  <?php else: ?>
    <!-- هذه فورايش حتى تعرض كافة البيانات -->
    <?php foreach ($news as $item): ?>
      
      <?php
      
        $imgSrc   = !empty($item['image']) ? 'uploads/' . htmlspecialchars($item['image']) : 'image.jpg';
        $catLabel =  htmlspecialchars($item['category']);
        $excerpt  = mb_strlen($item['content']) > 120 ? mb_substr($item['content'], 0, 120) . '...' : $item['content'];
      ?>
      <div class="news-card">
        <img src="<?= $imgSrc ?>" alt="صورة الخبر">
        <div class="news-content">
          <span class="category"><?= $catLabel ?></span>
          <h2><?= htmlspecialchars($item['title']) ?></h2>
          <p><?= htmlspecialchars($excerpt) ?></p>
          <a href="news-details.php?id=<?= (int)$item['id'] ?>" class="details-link">قراءة المزيد</a>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

</body>
</html>
