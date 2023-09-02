/** @type {Number} リクエストが成功 */
export const HTTP_OK = 200;

/** @type {Number} 植物の初期コメント数 */
export const COMMENT_COUNT = 5;

/** @type {Array} 生育場所ボタンの設定 */
export const placeLinks = [
  [
    "街路・生け垣",
    "https://images.unsplash.com/photo-1584326995991-8ec707ca7c5e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80",
  ],
  [
    "市街地・公園",
    "https://images.unsplash.com/photo-1575783970733-1aaedde1db74?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1476&q=80",
  ],
  [
    "神社・寺院",
    "https://images.unsplash.com/photo-1530634082454-f57b7d567b25?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80",
  ],
  [
    "道端・草地",
    "https://images.unsplash.com/photo-1562758619-78207a23a6e0?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80",
  ],
  [
    "空き地・土手",
    "https://images.unsplash.com/photo-1564122272812-ef0c0790db4f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80",
  ],
  [
    "田畑・あぜ",
    "https://images.unsplash.com/photo-1595668379004-4565dc72e10f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80",
  ],
  [
    "雑木林・林緑・やぶ",
    "https://images.unsplash.com/photo-1542202229-7d93c33f5d07?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80",
  ],
  [
    "水辺・海辺",
    "https://images.unsplash.com/photo-1515238152791-8216bfdf89a7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1472&q=80",
  ],
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
  "https://i.pinimg.com/1200x/9e/4d/b4/9e4db4faaf54b5ac51bd49603cd39a39.jpg",

  // 黄
  "https://www.medicalherb.or.jp/wp-content/uploads/2021/09/aramanda.jpg",

  // 橙
  "https://lovegreen.net/wp-content/uploads/2020/07/1d7640780a73fe25f729cab5255e40c1.jpg",

  // ピンク
  "https://yayoi-blog.info/wp-content/uploads/2017/08/tyu-rippunokisetu.jpg",

  // 赤
  "https://d2v9opmik2a3uk.cloudfront.net/uploads/2015/07/08171806/506ba69fba298ea9504f96f147c72c27.jpg",

  // 青
  "https://storage.minhana.net/wikidata/A1332/picture_users/A1332_picture_users.jpg",

  // 紫
  "https://d3pbyuzcd27kd.cloudfront.net/wp-content/uploads/sites/8/2020/02/05143857/ac78eebd9cbed6ca48cdc10dd3e5acab-e1631499860618.jpg",

  // 緑
  "https://bluegreen.jp/wp-content/uploads/2020/06/IMG_5179-1024x683.jpg",

  // その他
  "https://lovegreen.net/wp-content/uploads/2022/05/3505241_s.jpg",
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
    title: "ご利用にあたって",
    dest: "rules",
    icon: "mdi-menu-right",
  },
  { title: "お問い合わせ", dest: "contact", icon: "mdi-menu-right" },
];
