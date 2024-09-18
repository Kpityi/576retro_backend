<?php

// load necessary file
require_once "./middleware.php";
require_once "./db.php";

$gameID= $_GET['id'];


$sql = "SELECT  `name`,
                `release_year`,
                `rank`,
                comments.id As comment_id,
                comments.user_name,
                comments.comment,
                game_description.history,
                game_description.gameplay,
                game_description.graphics,
                images.id AS image_id,
                images.image_name,
                system_requirements.min_cpu,
                system_requirements.rec_cpu,
                system_requirements.min_gpu,
                system_requirements.rec_gpu,
                system_requirements.min_ram,
                system_requirements.rec_ram,
                system_requirements.min_storage,
                system_requirements.rec_storage,
                videos.video_url
            FROM `games`
            LEFT JOIN `comments` ON `games`.`id`= `comments`.`game_id`
            LEFT JOIN `game_description` ON `games`.`id`= `game_description`.`game_id`
            LEFT JOIN `images` ON `games`.`id`= `images`.`game_id`
            LEFT JOIN `system_requirements` ON `games`.`id`= `system_requirements`.`game_id`
            LEFT JOIN `videos` ON `games`.`id`= `videos`.`game_id`
            WHERE `games`.`id`=$gameID;";

$result = $conn->query($sql);

$gameData = [
  'game' => [],
  'comments' => [],
  'game_description' => [],
  'images' => [],
  'system_requirements' => [],
  'video_url' => ""
];


while ($row = $result->fetch_assoc()) {
  // Add game data
  if (empty($gameData['game'])) {
      $gameData['game'] = [
          'name' => $row['name'],
          'release_year' => $row['release_year'],
          'rank' => $row['rank']
      ];
  }

  // Add comments
  if (!is_null($row['comment_id']) && !in_array($row['comment_id'], array_column($gameData['comments'], 'id'))) {
    $gameData['comments'][] = [
        'id' => $row['comment_id'],
        'user_name' => $row['user_name'],
        'comment' => $row['comment']
    ];
  }

  // Add game description
  if (!is_null($row['history'])) {
      $gameData['game_description'] = [
          'history' => $row['history'],
          'gameplay' => $row['gameplay'],
          'graphics' => $row['graphics']
      ];
  }

  // Add images
  if (!is_null($row['image_id']) && !in_array($row['image_id'], array_column($gameData['images'], 'id'))) {
    $gameData['images'][] = [
        'id' => $row['image_id'],
        'image_name' => $row['image_name']
    ];
  }

  // Add system requirements
  if (!empty($row['min_cpu'])) {
      $gameData['system_requirements'] = [
          'min_cpu' => $row['min_cpu'],
          'rec_cpu' => $row['rec_cpu'],
          'min_gpu' => $row['min_gpu'],
          'rec_gpu' => $row['rec_gpu'],
          'min_ram' => $row['min_ram'],
          'rec_ram' => $row['rec_ram'],
          'min_storage' => $row['min_storage'],
          'rec_storage' => $row['rec_storage']
      ];
  }

  // Add video url
  if (empty($gameData['video_url'])) {
    $gameData['video_url'] = $row['video_url'];
  }
}

//Close connection
$conn->close();

//Send result
echo json_encode($gameData);

?>