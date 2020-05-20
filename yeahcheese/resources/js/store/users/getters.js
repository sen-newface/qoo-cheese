const getters = {
  user: state => state.user,
  isLogin: state => state.user && state.user.name ? true : false,
  validationMessage: state => state.validationMessage,
}
export default getters
