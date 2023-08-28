<div class="event-summary">
            <a class="event-summary__date t-center" href="#">
              <!-- event_date is the name we provided in plugin acf -->
              <span class="event-summary__month"><?php
              // php class --> it will return the current date if we don't provide it any date.
              $eventDate = new DateTime(get_field('event_date'));
              echo $eventDate->format('M')
              ?></span>
              <span class="event-summary__day"><?php 
               echo $eventDate->format('d')
              ?></span>
            </a>
            <div class="event-summary__content">
              <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
              <!-- wp_trim_words get two arguments, one the content we want to trim and second is number of words we want to trim. -->
              <?php if(has_excerpt()){
                // the_excerpt(); will create an automatic padding on each side, thus to tackle that we can use another function called get_the_excerpt()
                  echo get_the_excerpt();
              } else{
                echo wp_trim_words(get_the_content(), 18);
              } ?> <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
            </div>
          </div>