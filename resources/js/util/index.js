/** @type {Number} リクエストが成功 */
export const HTTP_OK = 200;

/** @type {Number} 植物の初期コメント数 */
export const COMMENT_COUNT = 5;

/** @type {Array} 生育場所ボタンの設定 */
export const placeLinks = [
  ["街路・生け垣", "storage/design/top/places/street.jpg"],
  ["市街地・公園", "storage/design/top/places/park.jpg"],
  ["神社・寺院", "storage/design/top/places/temple.jpg"],
  ["道端・草地", "storage/design/top/places/grassland.jpg"],
  ["空き地・土手", "storage/design/top/places/vacant.jpg"],
  ["田畑・あぜ", "storage/design/top/places/field.jpg"],
  ["雑木林・林緑・やぶ", "storage/design/top/places/forest.jpg"],
  ["水辺・海辺", "storage/design/top/places/seaside.jpg"],
];

/** @type {Array} 花の色 */
export const plantColors = [
  "白",
  "黄",
  "橙",
  "ピンク",
  "赤",
  "青",
  "紫",
  "緑",
  "その他",
];

/** @type {Array} 「花の色」タブの花の画像 */
export const plantColorImages = [
  // 白
  "storage/design/top/colors/daisies.jpg",

  // 黄
  "storage/design/top/colors/oxalis.jpg",

  // 橙
  "storage/design/top/colors/dahlia.jpg",

  // ピンク
  "storage/design/top/colors/tulip.jpg",

  // 赤
  "storage/design/top/colors/rose.jpg",

  // 青
  "storage/design/top/colors/nemophila.jpg",

  // 紫
  "storage/design/top/colors/pansy.jpg",

  // 緑
  "storage/design/top/colors/hydrangea.jpg",

  // その他
  "storage/design/top/colors/black_lily.jpg",
];

/** @type {Array{}} メニューから遷移するページ */
export const menuItems = [
  { title: "TOPページ", dest: "top", icon: "mdi-home" },
  { title: "会員登録", dest: "register", icon: "mdi-plus" },
  { title: "ログイン", dest: "login", icon: "mdi-login" },
  { title: "植物登録", dest: "storePlant", icon: "mdi-sprout" },
  { title: "ユーザー", dest: "about", icon: "mdi-account" },
];

/** @type {Array{}} 補足情報へのリンク */
export const links = [
  {
    title: "ご利用規則",
    dest: "rules",
    icon: "mdi-menu-right",
  },
  { title: "お問い合わせ", dest: "contact", icon: "mdi-menu-right" },
];
