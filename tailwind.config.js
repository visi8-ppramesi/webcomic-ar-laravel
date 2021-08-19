module.exports = {
  purge: [
      './resources/js/**/*.vue'
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      height: theme => ({
        "screen-navbar": "calc(100vh - 64px)",
        "screen/2": "50vh",
        "screen/3": "calc(100vh / 3)",
        "screen/4": "calc(100vh / 4)",
        "screen/5": "calc(100vh / 5)",
      }),
      width: theme => ({
        "screen/2": "50vw",
        "screen/3": "calc(100vw / 3)",
        "screen/4": "calc(100vw / 4)",
        "screen/5": "calc(100vw / 5)",
        "screen/6": "calc(100vw / 6)",
        "screen/8": "calc(100vw / 8)",
        "screen/10": "calc(100vw / 10)",
      }),
      maxHeight: theme => ({
        '0': '0',
        '1/4': '25%',
        '1/2': '50%',
        '3/4': '75%',
        'full': '100%',
      })
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
