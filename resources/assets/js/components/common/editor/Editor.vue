<template>
    <Ckeditor
        v-model="editorData"
        :editor="editor"
        :config="editorConfig"
    />
</template>

<script>
// ⚠️ NOTE: We don't use @ckeditor/ckeditor5-build-classic any more!
// Since we're building CKEditor from source, we use the source version of ClassicEditor.
import ClassicEditor from '@ckeditor/ckeditor5-editor-classic/src/classiceditor'
import EssentialsPlugin from '@ckeditor/ckeditor5-essentials/src/essentials'
import UploadAdapterPlugin from '@ckeditor/ckeditor5-adapter-ckfinder/src/uploadadapter'
import AutoformatPlugin from '@ckeditor/ckeditor5-autoformat/src/autoformat'
import BoldPlugin from '@ckeditor/ckeditor5-basic-styles/src/bold'
import ItalicPlugin from '@ckeditor/ckeditor5-basic-styles/src/italic'
import BlockQuotePlugin from '@ckeditor/ckeditor5-block-quote/src/blockquote'
import EasyImagePlugin from '@ckeditor/ckeditor5-easy-image/src/easyimage'
import HeadingPlugin from '@ckeditor/ckeditor5-heading/src/heading'
import ImagePlugin from '@ckeditor/ckeditor5-image/src/image'
import ImageCaptionPlugin from '@ckeditor/ckeditor5-image/src/imagecaption'
import ImageStylePlugin from '@ckeditor/ckeditor5-image/src/imagestyle'
import ImageToolbarPlugin from '@ckeditor/ckeditor5-image/src/imagetoolbar'
import ImageUploadPlugin from '@ckeditor/ckeditor5-image/src/imageupload'
import LinkPlugin from '@ckeditor/ckeditor5-link/src/link'
import ListPlugin from '@ckeditor/ckeditor5-list/src/list'
import ParagraphPlugin from '@ckeditor/ckeditor5-paragraph/src/paragraph'
import CodeBlockPlugin from '@ckeditor/ckeditor5-code-block/src/codeblock'
import HorizontalLine from '@ckeditor/ckeditor5-horizontal-line/src/horizontalline'
// import MediaEmbed from '@ckeditor/ckeditor5-media-embed/src/mediaembed';
import Table from '@ckeditor/ckeditor5-table/src/table'
import TableToolbar from '@ckeditor/ckeditor5-table/src/tabletoolbar'
import Alignment from '@ckeditor/ckeditor5-alignment/src/alignment'

// import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
import ckeditor from '@ckeditor/ckeditor5-vue'
import GFMDataProcessor from '@ckeditor/ckeditor5-markdown-gfm/src/gfmdataprocessor'
// Simple plugin which loads the data processor.
function Markdown (editor) {
    editor.data.processor = new GFMDataProcessor(editor.editing.view.document)
}

export default {
    components: {
        Ckeditor: ckeditor.component
    },
    props: {
        value: {
            type: String,
            default: ''
        }
    },
    data () {
        return {
            editor: ClassicEditor,
            editorData: this.value,
            editorConfig: {
                plugins: [
                    EssentialsPlugin,
                    BoldPlugin,
                    ItalicPlugin,
                    LinkPlugin,
                    ParagraphPlugin,
                    Image,
                    UploadAdapterPlugin,
                    AutoformatPlugin,
                    BlockQuotePlugin,
                    EasyImagePlugin,
                    ImagePlugin,
                    HeadingPlugin,
                    ImageCaptionPlugin,
                    ImageToolbarPlugin,
                    ImageStylePlugin,
                    ImageUploadPlugin,
                    ListPlugin,
                    CodeBlockPlugin,
                    HorizontalLine,
                    // MediaEmbed,
                    Table,
                    TableToolbar,
                    Alignment,
                    Markdown
                ],

                toolbar: {
                    items: [
                        'heading',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        'imageUpload',
                        'blockQuote',
                        'horizontalLine',
                        'codeBlock',
                        // 'mediaEmbed',
                        'insertTable',
                        'alignment',
                        'undo',
                        'redo'
                    ]
                },
                image: {
                    toolbar: [
                        'imageStyle:full',
                        'imageStyle:side',
                        '|',
                        'imageTextAlternative'
                    ]
                },
                codeBlock: {
                    languages: [
                        // Do not render the CSS class for the plain text code blocks.
                        { language: 'plaintext', label: 'Plain text', class: '' },

                        // Use the "php-code" class for PHP code blocks.
                        { language: 'php', label: 'PHP', class: 'php-code' },

                        // Use the "js" class for JavaScript code blocks.
                        // Note that only the first ("js") class will determine the language of the block when loading data.
                        { language: 'javascript', label: 'JavaScript', class: 'js javascript js-code' },

                        // Python code blocks will have the default "language-python" CSS class.
                        { language: 'python', label: 'Python' }
                    ]
                },
                table: {
                    contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                },
                alignment: {
                    options: ['left', 'right', 'center', 'justify']
                }
            }
        }
    },
    watch: {
        value (val) {
            if (val !== this.editorData) {
                this.editorData = val
            }
        },
        editorData (val) {
            if (val !== this.value) {
                this.$emit('input', val)
            }
        }
    }
}
</script>
