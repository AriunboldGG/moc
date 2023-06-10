<?php

/**
 * The template for Comments
 *
 * This is the template that displays Comment sections.
 *
 * @package ThemeWaves
 */

if (comments_open ()) { ?>
    <div class="entry-comments" id="comments"><?php
            if (post_password_required ()) { ?>
                <p class="nocomments"><?php esc_html_e('This post is password protected. Enter the password to view comments.', 'lvly'); ?></p><?php
            }else{
            
                if ( have_comments() ) : ?>
                    <div class="comment-title"><h4 class="np-title-line">
                        <?php 
                        $comments_number = get_comments_number();
                        if ( '1' === $comments_number ) {
                            /* translators: %s: post title */
                            echo esc_html( sprintf( _x( '1 Comment on &ldquo;%s&rdquo;', 'comments title', 'lvly' ), get_the_title() ));
                        } else {
                            echo esc_html( sprintf(
                                /* translators: 1: number of comments, 2: post title */
                                _nx(
                                    '%1$s Comment on &ldquo;%2$s&rdquo;',
                                    '%1$s Comments on &ldquo;%2$s&rdquo;',
                                    $comments_number,
                                    'comments title',
                                    'lvly'
                                ),
                                number_format_i18n( $comments_number ),
                                get_the_title()
                            ));
                        }?>                        
                    </h4></div>
                    <div class="comment-list clearfix">
                        <?php wp_list_comments(array('style' => 'div', 'callback' => 'lvly_comment')); ?>
                    </div>
                    <div class="navigation">
                        <div class="left"><?php previous_comments_link() ?></div>
                        <div class="right"><?php next_comments_link() ?></div>
                    </div><?php
                endif; // Check for have_comments().

                	// If comments are closed and there are comments, let's leave a little note, shall we?
                if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
                ?>
            
                    <p class="no-comments"><?php esc_html__( 'Comments are closed.', 'lvly' ); ?></p>
                <?php
                endif;


                $fields[ 'comment_notes_before' ]=$fields[ 'comment_notes_after' ] = '';
                $fields[ 'label_submit' ] = esc_html__('Submit Comment', 'lvly');
                $fields[ 'comment_field' ] = 
                    '<p class="comment-form-comment">'.
                        '<textarea name="comment" placeholder="'.esc_attr__('Your comment', 'lvly').'" id="comment" class="required" rows="7" tabindex="4"></textarea>'.
                    '</p>';
                $fields[ 'title_reply' ] = esc_html__('Leave a Reply', 'lvly');
                comment_form($fields);
            }
        ?>
    </div><?php
}