CREATE TABLE yaku_list (
    id INT AUTO_INCREMENT PRIMARY KEY,
    yaku_name VARCHAR(100) NOT NULL UNIQUE,
    yaku_detail TEXT
);

INSERT INTO yaku_list (yaku_name, yaku_detail) VALUES
('タンヤオ', '2〜8の数牌だけで完成する役。1・9・字牌を使わない。'),
('ピンフ', '全て順子だけで雀頭が役牌以外。両面待ち。'),
('役牌', '白、發、中、場風、自風牌の刻子が含まれる。'),
('一気通貫', '同色で1-9の順子3つを揃える。'),
('七対子', '7つの対子で作る役。'),
('国士無双', '1, 9, 字牌すべて1枚＋どれでも1つ対子。'),
('清一色', '1色だけで構成。');
-- 随時追加してください

CREATE TABLE questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category ENUM('基本','実践'),
    yaku_id INT,           -- yaku_list 参照
    yaku_name VARCHAR(100),
    question TEXT,
    tiles_json TEXT,       -- 手牌(JSON配列)
    missing_tile VARCHAR(32), -- 実践編（正解牌 ex: '5s'）
    choices_json TEXT,        -- 選択肢用(JSON配列)
    answer VARCHAR(100)
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);

CREATE TABLE answers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    question_id INT,
    user_answer VARCHAR(255),
    is_correct BOOLEAN,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (question_id) REFERENCES questions(id)
);

-- 基本編: 牌を見て役を答える（選択肢付き）
INSERT INTO questions (category, yaku_id, yaku_name, question, tiles_json, answer, choices_json)
VALUES (
  '基本',
  (SELECT id FROM yaku_list WHERE yaku_name='ピンフ'),
  'ピンフ',
  'この役の名前を答えてみよう！',
  '["2m","3m","4m","2p","3p","4p","5s","5s","5s","7m","8m","9m","3s","3s"]',
  'ピンフ',
  '["タンヤオ","ピンフ","役牌"]'
);

-- 基本編: ルール形式
INSERT INTO questions (category, yaku_id, yaku_name, question, tiles_json, answer, choices_json)
VALUES (
  '基本',
  (SELECT id FROM yaku_list WHERE yaku_name='タンヤオ'),
  'タンヤオ',
  '「タンヤオ」を作るには何が必要？（答えに「1, 9, 字牌」は不要）',
  NULL,
  '2～8の数牌だけ',
  '["端の牌が必要","2～8の数牌だけ","字牌だけでいい"]'
);

-- 実践編: 「あと1枚なに？」問題（3択・画像選択）
INSERT INTO questions (category, yaku_id, yaku_name, question, tiles_json, missing_tile, answer, choices_json)
VALUES (
  '実践',
  (SELECT id FROM yaku_list WHERE yaku_name='タンヤオ'),
  'タンヤオ',
  'この手でタンヤオを完成するにはあと何が必要？',
  '["2m","2m","3m","4m","6p","7p","6p","7p","8p","4s","5s","6s","8s"]',
  '7s',
  '7s',
  '["1z","9s","7s"]'
);
