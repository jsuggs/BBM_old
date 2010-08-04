#!/usr/bin/perl -w

use strict;
use LWP::Simple;
use URI::Escape;
use HTML::TreeBuilder;

my @teams = ('BAL','BOS','CHW','CLE','DET','KCR','ANA','MIN','NYY','OAK','SEA','TBD','TEX','TOR','ARI','ATL','CHC','CIN','COL','FLA','HOU','LAD','MIL','NYM','PHI','PIT','SDP','SFG','STL','WSN');


foreach my $team (@teams) {
    my $url = 'http://www.baseball-reference.com/teams/' . $team . '/2010-schedule-scores.shtml';

    print "Getting Schedule for $team -> $url\n";
    my $html = get $url;

    if (defined($html)) {
        open HTML, "> html/$team";
        print HTML $html;
        close HTML;
    }
    else {
        print "Unable to get content for $team";
    }

    sleep(int(rand(120)));
}
