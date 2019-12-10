import MarkdownIt from 'markdown-it'

export default ({ app }, inject) => {
  const md = new MarkdownIt({"breaks":true,"html":true,"linkify":true,"typography":true})

  md.use(require('markdown-it-toc'))

  inject('md', md)
}