Vue.component("file-name", {
  data: function() {
    return {
        name: '',
    }
  },
  methods: {

  },
  template: `
<div id="fn-settings">
  <b><slot></slot></b>
  <input v-model="name" placeholder="description">

</div>
`
})
