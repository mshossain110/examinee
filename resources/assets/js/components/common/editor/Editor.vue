<template>
    <div class="text-editor">
        <div class="row">
            <div class="col-3">
                <AttachFiles
                    sidebar
                    @input="insetFileIntoEditor"
                />
            </div>
            <div class="col-9" />
        </div>
        <div class="row">
            <div class="col-12">
                <Ckeditor
                    v-model="editorData"
                    :editor="editorType"
                    :config="editorConfig"
                    @ready="editorReady"
                />
            </div>
        </div>
    </div>
</template>

<script>

// The official CKEditor 5 instance inspector. It helps understand the editor view and model.
// import CKEditorInspector from '@ckeditor/ckeditor5-inspector'

// ⚠️ NOTE: We don't use @ckeditor/ckeditor5-build-classic any more!
// Since we're building CKEditor from source, we use the source version of ClassicEditor.
import AttachFiles from '@c/common/dropzone/AttachFiles.vue'
import ClassicEditor from '@ckeditor/ckeditor5-editor-classic/src/classiceditor'
import EssentialsPlugin from '@ckeditor/ckeditor5-essentials/src/essentials'
import UploadAdapterPlugin from '@ckeditor/ckeditor5-adapter-ckfinder/src/uploadadapter'
import EasyImagePlugin from '@ckeditor/ckeditor5-easy-image/src/easyimage'
import AutoformatPlugin from '@ckeditor/ckeditor5-autoformat/src/autoformat'
import BoldPlugin from '@ckeditor/ckeditor5-basic-styles/src/bold'
import ItalicPlugin from '@ckeditor/ckeditor5-basic-styles/src/italic'
import BlockQuotePlugin from '@ckeditor/ckeditor5-block-quote/src/blockquote'
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
        Ckeditor: ckeditor.component,
        AttachFiles
    },
    props: {
        value: {
            type: String,
            default: ''
        }
    },
    data () {
        return {
            editor: null,
            editorType: ClassicEditor,
            editorData: this.value,
            editorConfig: {
                startupMode: 'source',
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
                    // You need to configure the image toolbar, too, so it uses the new style buttons.
                    toolbar: [
                        'imageTextAlternative',
                        '|',
                        'imageStyle:alignLeft',
                        'imageStyle:full',
                        'imageStyle:alignRight',
                        'imageStyle:side',
                        'imageStyle:alignCenter'
                    ],

                    styles: [
                        // This option is equal to a situation where no style is applied.
                        'full',
                        'side',
                        // This represents an image aligned to the left.
                        'alignLeft',
                        'alignCenter',

                        // This represents an image aligned to the right.
                        'alignRight'
                    ],
                    resizeUnit: 'px'
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
    },

    methods: {
        editorReady (editor) {
            this.editor = editor

            // CKEditorInspector.attach(editor)
        },
        insetFileIntoEditor (file) {
            this.editor.execute('imageInsert', { source: file.public_path })
        }
    }
}
</script>
